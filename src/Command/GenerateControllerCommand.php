<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Command;

use InvalidArgumentException;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Command\Helper\GeneratorCommandAbstract;
use MjrOne\CodeGeneratorBundle\Command\Helper\QuestionHelper;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorDriverInterface;
use RuntimeException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class GenerateControllerCommand
 *
 * @package   MjrOne\CodeGeneratorBundle\Command
 * @package   MjrOne\CodeGeneratorBundle\Command\Helper
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class GenerateControllerCommand extends GeneratorCommandAbstract
{
    const REGEX_TEMPLATE_NAME_1   = '/([A-Z]+)([A-Z][a-z])/';
    const REGEX_TEMPLATE_NAME_2   = '/([a-z\d])([A-Z])/';
    const REGEX_ROUTE_PLACEHOLDER = '/{(.*?)}/';

    /**
     * @see Command
     */
    public function configure()
    {
        $this
            ->setName('mjr:generateController')
            ->setDescription('Generates a controller')
            ->setDefinition(
                [
                    new InputOption(
                        'controller',
                        'c',
                        InputOption::VALUE_REQUIRED, 'The name of the controller to create'
                    ),
                    new InputOption(
                        'route-format',
                        'f',
                        InputOption::VALUE_REQUIRED,
                        'The format that is used for the routing (yml, xml, php, annotation)', 'annotation'
                    ),
                    new InputOption(
                        'template-format',
                        't',
                        InputOption::VALUE_REQUIRED,
                        'The format that is used for templating (twig, php)',
                        'twig'
                    ),
                    new InputOption(
                        'actions',
                        'a',
                        InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                        'The actions in the controller'
                    ),
                ]
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws RuntimeException
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();

        if ($input->isInteractive())
        {
            $question =
                new ConfirmationQuestion($questionHelper->getQuestion('Do you confirm generation', 'yes', '?'), true);
            if (!$questionHelper->ask($input, $output, $question))
            {
                $output->writeln('<error>Command aborted</error>');

                return 1;
            }
        }

        if (null === $input->getOption('controller'))
        {
            throw new RuntimeException('The controller option must be provided.');
        }

        $validator = $this->getContainer()->get('mjrone.codegenerator.validatior.bundle');

        list($bundle, $controller) = $this->parseShortcutNotation($input->getOption('controller'));
        if (is_string($bundle))
        {
            $bundle = $validator->validateBundleName($bundle);

            try
            {
                $bundle = $this->getContainer()->get('kernel')->getBundle($bundle);
            } catch (\Exception $e)
            {
                $output->writeln(sprintf('<bg=red>Bundle "%s" does not exist.</>', $bundle));
            }
        }

        $questionHelper->printSection($output, 'Controller generation');
        /** @var \MjrOne\CodeGeneratorBundle\Generator\ControllerGenerator $generator */
        $generator = $this->getGenerator($bundle);
        $generator->generate(
            $bundle,
            $controller,
            $input->getOption('route-format'),
            $input->getOption('template-format'),
            $this->parseActions($input->getOption('actions'))
        );

        $output->writeln('Generating the bundle code: <info>OK</info>');

        $questionHelper->printOperationSummary($output, array());

        return 0;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function interact(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        $questionHelper->printSection($output, 'Welcome to the Symfony controller generator');

        // namespace
        $output->writeln(
            array(
                '',
                'Every page, and even sections of a page, are rendered by a <comment>controller</comment>.',
                'This command helps you generate them easily.',
                '',
                'First, you need to give the controller name you want to generate.',
                'You must use the shortcut notation like <comment>AcmeBlogBundle:Post</comment>',
                '',
            )
        );

        $bundleNames = array_keys($this->getContainer()->get('kernel')->getBundles());

        $bundle = $controller = null;
        $validator = $this->getContainer()->get('mjrone.codegenerator.validatior.bundle');

        while (true)
        {
            $question = new Question(
                $questionHelper->getQuestion('Controller name', $input->getOption('controller')),
                $input->getOption('controller')
            );
            $question->setAutocompleterValues($bundleNames);
            $question->setValidator(
                array('Sensio\Bundle\GeneratorBundle\Command\Validators', 'validateControllerName')
            );
            $controller = $questionHelper->ask($input, $output, $question);
            list($bundle, $controller) = $this->parseShortcutNotation($controller);

            try
            {
                $b = $this->getContainer()->get('kernel')->getBundle($bundle);

                if (!file_exists($b->getPath() . '/Controller/' . $controller . 'Controller.php'))
                {
                    break;
                }

                $output->writeln(sprintf('<bg=red>Controller "%s:%s" already exists.</>', $bundle, $controller));
            } catch (\Exception $e)
            {
                $output->writeln(sprintf('<bg=red>Bundle "%s" does not exist.</>', $bundle));
            }
        }

        if ($bundle === null || $controller === null)
        {
            throw new RuntimeException('Nothing is set');
        }
        $input->setOption('controller', $bundle . ':' . $controller);

        // routing format
        $defaultFormat =
            (null !== $input->getOption('route-format') ? $input->getOption('route-format') : 'annotation');
        $output->writeln(
            [
                '',
                'Determine the format to use for the routing.',
                '',
            ]
        );
        $question = new Question(
            $questionHelper->getQuestion(
                'Routing format (php, xml, yml, annotation)',
                $defaultFormat
            ),
            $defaultFormat
        );
        $question->setValidator(
            function ($format) use ($validator)
            {
                return $validator->validateFormat($format);
            }
        );

        $routeFormat = $questionHelper->ask($input, $output, $question);

        $input->setOption('route-format', $routeFormat);

        // templating format
        $validateTemplateFormat = function ($format)
        {
            if (!in_array($format, ['twig', 'php']))
            {
                throw new InvalidArgumentException(
                    sprintf('The template format must be twig or php, "%s" given', $format)
                );
            }

            return $format;
        };

        $defaultFormat = ($input->getOption('template-format') ?? 'twig');
        $output->writeln(
            [
                '',
                'Determine the format to use for templating.',
                '',
            ]
        );
        $question = new Question(
            $questionHelper->getQuestion(
                'Template format (twig, php)',
                $defaultFormat
            ),
            $defaultFormat
        );
        $question->setValidator($validateTemplateFormat);

        $templateFormat = $questionHelper->ask($input, $output, $question);
        $input->setOption('template-format', $templateFormat);

        // actions
        $input->setOption('actions', $this->addActions($input, $output, $questionHelper));

        // summary
        $output->writeln(
            [
                '',
                $this->getHelper('formatter')->formatBlock('Summary before generation', 'bg=blue;fg-white', true),
                '',
                sprintf('You are going to generate a "<info>%s:%s</info>" controller', $bundle, $controller),
                sprintf(
                    'using the "<info>%s</info>" format for the routing and the "<info>%s</info>" format', $routeFormat,
                    $templateFormat
                ),
                'for templating',
            ]
        );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface           $input
     * @param \Symfony\Component\Console\Output\OutputInterface         $output
     * @param \MjrOne\CodeGeneratorBundle\Command\Helper\QuestionHelper $questionHelper
     *
     * @return array
     */
    public function addActions(InputInterface $input, OutputInterface $output, QuestionHelper $questionHelper)
    {
        $output->writeln(
            array(
                '',
                'Instead of starting with a blank controller, you can add some actions now. An action',
                'is a PHP function or method that executes, for example, when a given route is matched.',
                'Actions should be suffixed by <comment>Action</comment>.',
                '',
            )
        );

        $templateNameValidator = function ($name)
        {
            if ('default' === $name)
            {
                return $name;
            }

            if (2 != substr_count($name, ':'))
            {
                throw new InvalidArgumentException(sprintf('Template name "%s" does not have 2 colons', $name));
            }

            return $name;
        };

        $actions = $this->parseActions($input->getOption('actions'));

        while (true)
        {
            // name
            $output->writeln('');
            $question = new Question(
                $questionHelper->getQuestion('New action name (press <return> to stop adding actions)', null), null
            );
            $question->setValidator(
                function ($name) use ($actions)
                {
                    if (null == $name)
                    {
                        return $name;
                    }

                    if (isset($actions[$name]))
                    {
                        throw new InvalidArgumentException(sprintf('Action "%s" is already defined', $name));
                    }

                    if ('Action' !== substr($name, -6))
                    {
                        throw new InvalidArgumentException(sprintf('Name "%s" is not suffixed by Action', $name));
                    }

                    return $name;
                }
            );

            $actionName = $questionHelper->ask($input, $output, $question);
            if (!$actionName)
            {
                break;
            }

            // route
            $question = new Question(
                $questionHelper->getQuestion('Action route', '/' . substr($actionName, 0, -6)),
                '/' . substr($actionName, 0, -6)
            );
            $route = $questionHelper->ask($input, $output, $question);
            $placeholders = $this->getPlaceholdersFromRoute($route);

            // template
            $defaultTemplate = $input->getOption('controller') . ':' .
                               strtolower(
                                   preg_replace
                                   (
                                       [
                                           self::REGEX_TEMPLATE_NAME_1,
                                           self::REGEX_TEMPLATE_NAME_2,
                                       ],
                                       [
                                           '\\1_\\2',
                                           '\\1_\\2',
                                       ], strtr(
                                           substr(
                                               $actionName,
                                               0,
                                               -6
                                           ),
                                           '_',
                                           '.'
                                       )
                                   )
                               )
                               . '.html.'
                               . $input->getOption('template-format');

            $question = new Question(
                $questionHelper->getQuestion('Template name (optional)', $defaultTemplate), $defaultTemplate
            );
            $template = $questionHelper->ask($input, $output, $question);
            // adding action
            $actions[$actionName] = array(
                'name'         => $actionName,
                'route'        => $route,
                'placeholders' => $placeholders,
                'template'     => $template,
            );
        }

        return $actions;
    }

    /**
     * @param $actions
     *
     * @return array
     */
    public function parseActions($actions)
    {
        if (empty($actions) || $actions !== array_values($actions))
        {
            return $actions;
        }

        // '$actions' can be an array with just 1 element defining several actions
        // separated by white spaces: $actions = array('... ... ...');
        if (1 === count($actions))
        {
            $actions = explode(' ', $actions[0]);
        }

        $parsedActions = array();

        foreach ($actions as $action)
        {
            $data = explode(':', $action);

            // name
            if (!isset($data[0]))
            {
                throw new InvalidArgumentException('An action must have a name');
            }
            $name = array_shift($data);

            // route
            $route = (isset($data[0]) && '' !== $data[0]) ? array_shift($data) : '/' . substr($name, 0, -6);
            if ($route)
            {
                $placeholders = $this->getPlaceholdersFromRoute($route);
            }
            else
            {
                $placeholders = array();
            }

            // template
            $template = (0 < count($data) && '' !== $data[0]) ? implode(':', $data) : 'default';

            $parsedActions[$name] = array(
                'name'         => $name,
                'route'        => $route,
                'placeholders' => $placeholders,
                'template'     => $template,
            );
        }

        return $parsedActions;
    }

    /**
     * @param $route
     *
     * @return mixed
     */
    public function getPlaceholdersFromRoute($route)
    {
        preg_match_all(self::REGEX_ROUTE_PLACEHOLDER, $route, $placeholders);
        $placeholders = $placeholders[1];

        return $placeholders;
    }

    /**
     * @param $shortcut
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function parseShortcutNotation($shortcut): array
    {
        $entity = str_replace('/', '\\', $shortcut);

        if (false === $pos = strpos($entity, ':'))
        {
            throw new InvalidArgumentException(
                sprintf(
                    'The controller name must contain a : ("%s" given, expecting something like AcmeBlogBundle:Post)',
                    $entity
                )
            );
        }

        return array(substr($entity, 0, $pos), substr($entity, $pos + 1));
    }

    /**
     * @return GeneratorDriverInterface
     * @throws \LogicException
     */
    protected function createGenerator(): GeneratorDriverInterface
    {
        return $this->getContainer()->get('mjrone.codegenerator.generator.controller');
    }
}
