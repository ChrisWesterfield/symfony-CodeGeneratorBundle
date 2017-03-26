<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Command;

use MjrOne\CodeGeneratorBundle\Command\Helper\GeneratorCommandAbstract;
use MjrOne\CodeGeneratorBundle\Document\Bundle;
use MjrOne\CodeGeneratorBundle\Generator\BundleGenerator;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorInterface;
use MjrOne\CodeGeneratorBundle\Services\CreateBundleService;
use RuntimeException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\HttpKernel\KernelInterface;


/**
 * Class GenerateBundleCommand
 *
 * @package MjrOne\CodeGeneratorBundle\Command
 * @author    Chris Westerfield <chris@mjr.one>
 * @author Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class GenerateBundleCommand extends GeneratorCommandAbstract
{
    /**
     *
     */
    protected function configure(): void
    {
        $this
            ->setName('mjr:generateBundle')->setDescription('Generates a bundle')
            ->setDefinition(
                [
                    new InputOption(
                        'namespace', 'a', InputOption::VALUE_REQUIRED,
                        'The namespace of the bundle to create'
                    ),
                    new InputOption(
                        'dir', 'd', InputOption::VALUE_REQUIRED, 'The directory where to create the bundle',
                        'src/'
                    ),
                    new InputOption(
                        'bundle-name', 'b', InputOption::VALUE_REQUIRED, 'The optional bundle name'
                    ),
                    new InputOption(
                        'format', 'f', InputOption::VALUE_REQUIRED,
                        'Use the format for configuration files (php, xml, yml, or annotation)'
                    ),
                    new InputOption(
                        'shared', 's', InputOption::VALUE_NONE,
                        'Are you planning on sharing this bundle across multiple applications?'
                    ),
                    new InputOption(
                        'createSourceDirectory', 'r', InputOption::VALUE_NONE,
                        'Move All Application logics into src/ folder'
                    ),
                    new InputOption(
                        'createComposer', 'c', InputOption::VALUE_NONE,
                        'Do you want to create the Composer File'
                    ),
                    new InputOption(
                        'createDefaultController', 'l', InputOption::VALUE_NONE,
                        'Do you want to create the default Controller'
                    ),
                    new InputOption(
                        'useMjrRouterUpdater', 'm', InputOption::VALUE_NONE,
                        'should Routing be updated using the \'mjr:generateRouting\' command (only works if kernel is updated!)'
                    ),
                    new InputOption(
                        'doNotUpdateKernel', 'k', InputOption::VALUE_NONE,
                        'Don\'t update the Application Kernel (useful for Composer Bundles)'
                    ),
                ]
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     * @throws \RuntimeException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $questionHelper = $this->getQuestionHelper();

        $bundle = $this->createBundleObject($input);
        $questionHelper->printSection($output, 'Bundle generation');

        /** @var BundleGenerator $generator */
        $generator = $this->createGenerator();

        $output->writeln(
            sprintf(
                '> Generating a sample bundle skeleton into <info>%s</info>',
                $this->makePathRelative($bundle->getTargetDirectory())
            )
        );
        $generator->generateBundle($bundle);

        $errors = array();

        if(!$bundle->isUpdateKernel())
        {
            // check that the namespace is already autoloaded
            $this->checkAutoloader($output, $bundle);

            // register the bundle in the Kernel class
            $this->updateKernel($output, $bundle);
        }

        if (!$bundle->shouldGenerateDependencyInjectionDirectory())
        {
            // we need to import their services.yml manually!
            $this->updateConfiguration($output, $bundle);
        }

        if(!$bundle->isUseRouteUpdates())
        {
            // routing importing
            $this->updateRouting($output, $bundle);
        }
        else
        {
            $command = $this->getApplication()->find('mjr:generateRouting');
            $arguments = [
                'command' => 'mjr:generateRouting',
                'cleanup' => true,
            ];
            $inputCom = new ArrayInput($arguments);
            $returnCode = $command->run($inputCom, $output);
            if($returnCode !== 0)
            {
                $output->writeln('<error>Routing could not be updated! Please Check the Output above</error>');
            }
        }

        $questionHelper->printOperationSummary($output, $errors);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        $questionHelper->printSection($output, 'Welcome to the Symfony bundle generator!');

        /*
         * shared option
         */
        $shared = $input->getOption('shared');
        // ask, but use $shared as the default
        $question = new ConfirmationQuestion(
            $questionHelper->getQuestion(
                'Are you planning on sharing this bundle across multiple applications?',
                $shared ? 'yes' : 'no'
            ), $shared
        );
        $shared = $questionHelper->ask($input, $output, $question);
        $input->setOption('shared', $shared);

        /*
         * namespace option
         */
        $namespace = $input->getOption('namespace');
        $output->writeln(
            array(
                '',
                'Your application code must be written in <comment>bundles</comment>. This command helps',
                'you generate them easily.',
                '',
            )
        );

        $askForBundleName = true;
        if ($shared)
        {
            // a shared bundle, so it should probably have a vendor namespace
            $output->writeln(
                array(
                    'Each bundle is hosted under a namespace (like <comment>Acme/BlogBundle</comment>).',
                    'The namespace should begin with a "vendor" name like your company name, your',
                    'project name, or your client name, followed by one or more optional category',
                    'sub-namespaces, and it should end with the bundle name itself',
                    '(which must have <comment>Bundle</comment> as a suffix).',
                    '',
                    'See http://symfony.com/doc/current/cookbook/bundles/best_practices.html#bundle-name for more',
                    'details on bundle naming conventions.',
                    '',
                    'Use <comment>/</comment> instead of <comment>\\ </comment> for the namespace delimiter to avoid any problem.',
                    '',
                )
            );

            $question = new Question(
                $questionHelper->getQuestion(
                    'Bundle namespace',
                    $namespace
                ), $namespace
            );
            $question->setValidator(
                function ($answer)
                {
                    return $this
                        ->getContainer()
                        ->get('mjrone.codegenerator.validatior.bundle')
                        ->validateBundleNamespace($answer, true);
                }
            );
            $namespace = $questionHelper->ask($input, $output, $question);
        }
        else
        {
            // a simple application bundle
            $output->writeln(
                array(
                    'Give your bundle a descriptive name, like <comment>BlogBundle</comment>.',
                )
            );

            $question = new Question(
                $questionHelper->getQuestion(
                    'Bundle name',
                    $namespace
                ), $namespace
            );
            $question->setValidator(
                function ($inputNamespace)
                {
                    return $this
                        ->getContainer()
                        ->get('mjrone.codegenerator.validatior.bundle')
                        ->validateBundleNamespace($inputNamespace, false);
                }
            );
            $namespace = $questionHelper->ask($input, $output, $question);

            if (strpos($namespace, '\\') === false)
            {
                // this is a bundle name (FooBundle) not a namespace (Acme\FooBundle)
                // so this is the bundle name (and it is also the namespace)
                $input->setOption('bundle-name', $namespace);
                $askForBundleName = false;
            }
        }
        $input->setOption('namespace', $namespace);

        /*
         * bundle-name option
         */
        if ($askForBundleName)
        {
            $bundle = $input->getOption('bundle-name');
            // no bundle yet? Get a default from the namespace
            if (!$bundle)
            {
                $bundle = strtr($namespace, array('\\Bundle\\' => '', '\\' => ''));
            }

            $output->writeln(
                array(
                    '',
                    'In your code, a bundle is often referenced by its name. It can be the',
                    'concatenation of all namespace parts but it\'s really up to you to come',
                    'up with a unique name (a good practice is to start with the vendor name).',
                    'Based on the namespace, we suggest <comment>' . $bundle . '</comment>.',
                    '',
                )
            );
            $question = new Question(
                $questionHelper->getQuestion(
                    'Bundle name',
                    $bundle
                ), $bundle
            );
            $question->setValidator(
                function ($name)
                {
                    return $this
                        ->getContainer()
                        ->get('mjrone.codegenerator.validatior.bundle')
                        ->validateBundleName($name);
                }
            );
            $bundle = $questionHelper->ask($input, $output, $question);
            $input->setOption('bundle-name', $bundle);
        }

        /*
         * dir option
         */
        // defaults to src/ in the option
        $dir = $input->getOption('dir');
        $output->writeln(
            array(
                '',
                'Bundles are usually generated into the <info>src/</info> directory. Unless you\'re',
                'doing something custom, hit enter to keep this default!',
                '',
            )
        );

        $question = new Question(
            $questionHelper->getQuestion(
                'Target Directory',
                $dir
            ), $dir
        );
        $dir = $questionHelper->ask($input, $output, $question);
        $input->setOption('dir', $dir);

        /*
         * format option
         */
        $format = $input->getOption('format');
        if (!$format)
        {
            $format = $shared ? 'xml' : 'annotation';
        }
        $output->writeln(
            array(
                '',
                'What format do you want to use for your generated configuration?',
                '',
            )
        );

        $question = new Question(
            $questionHelper->getQuestion(
                'Configuration format (annotation, yml, xml, php)',
                $format
            ), $format
        );
        $question->setValidator(
            function ($format)
            {
                return $this
                    ->getContainer()
                    ->get('mjrone.codegenerator.validatior.bundle')
                    ->validateFormat($format);
            }
        );
        $question->setAutocompleterValues(array('annotation', 'yml', 'xml', 'php'));
        $format = $questionHelper->ask($input, $output, $question);
        $input->setOption('format', $format);


        /*
         * create Source Directory
         */
        $srcDir = $input->getOption('createSourceDirectory');
        // ask, but use $shared as the default
        $question = new ConfirmationQuestion(
            $questionHelper->getQuestion(
                'Move All Application logics into src/ folder',
                $srcDir ? 'yes' : 'no'
            ), $srcDir
        );
        $srcDir = $questionHelper->ask($input, $output, $question);
        $input->setOption('createSourceDirectory', $srcDir);


        /*
         * create composer
         */
        $createComposer = $input->getOption('createComposer');
        // ask, but use $shared as the default
        $question = new ConfirmationQuestion(
            $questionHelper->getQuestion(
                'Do you want to create the Composer File',
                $createComposer ? 'yes' : 'no'
            ), $createComposer
        );
        $createComposer = $questionHelper->ask($input, $output, $question);
        $input->setOption('createComposer', $createComposer);


        /*
         * create default Controller
         */
        $createDefaultController = $input->getOption('createDefaultController');
        // ask, but use $shared as the default
        $question = new ConfirmationQuestion(
            $questionHelper->getQuestion(
                'Do you want to create the default Controller',
                $createDefaultController ? 'yes' : 'no'
            ), $createDefaultController
        );
        $createDefaultController = $questionHelper->ask($input, $output, $question);
        $input->setOption('createDefaultController', $createDefaultController);

        /*
         * update Kernel
         */
        $updateKernel = $input->getOption('doNotUpdateKernel');
        // ask, but use $shared as the default
        $question = new ConfirmationQuestion(
            $questionHelper->getQuestion(
                'Should the Symfony Application Kernel not be updated (useful for Composer Bundles which should be added using composer update)',
                $updateKernel ? 'yes' : 'no'
            ), $updateKernel
        );
        $updateKernel = $questionHelper->ask($input, $output, $question);
        $input->setOption('doNotUpdateKernel', $updateKernel);

        if(!$updateKernel)
        {
            /*
             * use MjrOneCodeGenerator Routing Updator
             */
            $useRouter = $input->getOption('useMjrRouterUpdater');
            // ask, but use $shared as the default
            $question = new ConfirmationQuestion(
                $questionHelper->getQuestion(
                    'Do you want to use the \'mjr:generateRouting\' command to update Symfony Routing File? (Will be executed when the Bundle was created!)',
                    $useRouter ? 'yes' : 'no'
                ), $useRouter
            );
            $useRouter = $questionHelper->ask($input, $output, $question);
            $input->setOption('useMjrRouterUpdater', $useRouter);
        }

    }

    /**
     * @param OutputInterface $output
     * @param Bundle          $bundle
     *
     * @return array
     */
    protected function checkAutoloader(OutputInterface $output, Bundle $bundle): array
    {
        $output->writeln('> Checking that the bundle is autoloaded');
        if (!class_exists($bundle->getBundleClassName()))
        {
            return array(
                '- Edit the <comment>composer.json</comment> file and register the bundle',
                '  namespace in the "autoload" section:',
                '',
            );
        }

        return [];
    }

    /**
     * @param OutputInterface $output
     * @param Bundle          $bundle
     *
     * @return array
     */
    protected function updateKernel(OutputInterface $output, Bundle $bundle): array
    {
        $kernelManipulator = $this->getContainer()->get('mjrone.codegenerator.generator.manipulator.kernel');

        $output->writeln(
            sprintf(
                '> Enabling the bundle inside <info>%s</info>',
                $this->makePathRelative($kernelManipulator->getFilename())
            )
        );

        try
        {
            $ret = $kernelManipulator->addBundle($bundle->getBundleClassName());

            if (!$ret)
            {
                return
                    [
                        sprintf('- Edit <comment>%s</comment>', $kernelManipulator->getReflection()->getFileName()),
                        '  and add the following bundle in the <comment>AppKernel::registerBundles()</comment> method:',
                        '',
                        sprintf('    <comment>new %s(),</comment>', $bundle->getBundleClassName()),
                        '',
                    ];
            }
        } catch (RuntimeException $e)
        {
            return
                [
                    sprintf(
                        'Bundle <comment>%s</comment> is already defined in <comment>AppKernel::registerBundles()</comment>.',
                        $bundle->getBundleClassName()
                    ),
                    '',
                ];
        }
        return [];
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \MjrOne\CodeGeneratorBundle\Document\Bundle       $bundle
     *
     * @return array
     */
    protected function updateRouting(OutputInterface $output, Bundle $bundle):array
    {
        $routing = $this->getContainer()->get('mjrone.codegenerator.generator.manipulator.router');
        $output->writeln(
            sprintf(
                '> Importing the bundle\'s routes from the <info>%s</info> file',
                $this->makePathRelative($routing->getFile())
            )
        );
        try
        {
            $ret = $routing->addResource($bundle->getName(), $bundle->getConfigurationFormat());
            if (!$ret)
            {
                if ('annotation' === $bundle->getConfigurationFormat())
                {
                    $help = sprintf(
                        "        <comment>resource: \"@%s/Controller/\"</comment>\n        <comment>type:     annotation</comment>\n",
                        $bundle->getName()
                    );
                }
                else
                {
                    $help = sprintf(
                        "        <comment>resource: \"@%s/Resources/config/routing.%s\"</comment>\n",
                        $bundle->getName(), $bundle->getConfigurationFormat()
                    );
                }
                $help .= "        <comment>prefix:   /</comment>\n";

                return [
                    '- Import the bundle\'s routing resource in the app\'s main routing file:',
                    '',
                    sprintf('    <comment>%s:</comment>', $bundle->getName()),
                    $help,
                    '',
                ];
            }
        } catch (RuntimeException $e)
        {
            return [
                sprintf('Bundle <comment>%s</comment> is already imported.', $bundle->getName()),
                '',
            ];
        }
        return [];
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \MjrOne\CodeGeneratorBundle\Document\Bundle       $bundle
     *
     * @return array
     */
    protected function updateConfiguration(OutputInterface $output, Bundle $bundle):array
    {
        $targetConfigurationPath = $this->getContainer()->getParameter('kernel.root_dir') . '/config/config.yml';
        $output->writeln(
            sprintf(
                '> Importing the bundle\'s %s from the <info>%s</info> file',
                $bundle->getServicesConfigurationFilename(),
                $this->makePathRelative($targetConfigurationPath)
            )
        );
        $manipulator = $this
            ->getContainer()
            ->get('mjrone.codegenerator.generator.manipulator.configuration')
            ->setFile($targetConfigurationPath);
        try
        {
            $manipulator->addResource($bundle);
        }
        catch (RuntimeException $e)
        {
            return array(
                sprintf(
                    '- Import the bundle\'s "%s" resource in the app\'s main configuration file:',
                    $bundle->getServicesConfigurationFilename()
                ),
                '',
                $manipulator->getImportCode($bundle),
                '',
            );
        }
        return [];
    }

    /**
     * @param InputInterface $input
     *
     * @return Bundle
     * @throws \LogicException
     * @throws \RuntimeException
     */
    protected function createBundleObject(InputInterface $input):Bundle
    {
        foreach (array('namespace', 'dir') as $option)
        {
            if (null === $input->getOption($option))
            {
                throw new RuntimeException(sprintf('The "%s" option must be provided.', $option));
            }
        }

        $shared = $input->getOption('shared');
        $validator = $this->getContainer()->get('mjrone.codegenerator.validatior.bundle');
        $namespace = $validator->validateBundleNamespace($input->getOption('namespace'), $shared);
        if (!$bundleName = $input->getOption('bundle-name'))
        {
            $bundleName = strtr($namespace, array('\\' => ''));
        }
        $bundleName = $validator->validateBundleName($bundleName);
        $dir = $input->getOption('dir');
        if (null === $input->getOption('format'))
        {
            $input->setOption('format', 'annotation');
        }
        $format = $validator->validateFormat($input->getOption('format'));
        $projectRootDirectory = $this->getGenerator()->getProjectRootDirectory();
        if (!$this->getContainer()->get('filesystem')->isAbsolutePath($dir))
        {
            $dir = $projectRootDirectory . '/' . $dir;
        }
        $dir = '/' === substr($dir, -1, 1) ? $dir : $dir . '/';
        $dir = str_replace('//','/',$dir);
        $createSource = $input->getOption('createSourceDirectory');
        $createComposer = $input->getOption('createComposer');
        $createDefaultController = $input->getOption('createDefaultController');
        $router = $input->getOption('useMjrRouterUpdater');
        $kernelUpdate = $input->getOption('doNotUpdateKernel');

        $setting = [
            'nameSpace'               => $namespace,
            'name'                    => $bundleName,
            'targetDirectory'         => $dir,
            'configurationFormat'     => $format,
            'shared'                  => $shared,
            'createSource'            => $createSource,
            'createComposer'          => $createComposer,
            'createDefaultController' => $createDefaultController,
            'useRouteUpdates'         => $router,
            'updateKernel'            => $kernelUpdate,
        ];
        $bundle = new Bundle($setting);

        if (!$shared)
        {
            $testsDir = $projectRootDirectory . '/tests/' . $bundleName;
            $bundle->setTestsDirectory($testsDir);
        }

        return $bundle;
    }

    /**
     * @return \MjrOne\CodeGeneratorBundle\Generator\GeneratorInterface
     * @throws \LogicException
     */
    protected function createGenerator(): GeneratorInterface
    {
        return $this->getContainer()->get('mjrone.codegenerator.generator.bundle');
    }
}
