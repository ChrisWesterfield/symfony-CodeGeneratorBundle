<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Command;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Command\Helper\GeneratorCommandAbstract;
use MjrOne\CodeGeneratorBundle\Generator\CommandGenerator;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorInterface;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class GenerateCommandCommand
 *
 * @package MjrOne\CodeGeneratorBundle\Command
 * @package MjrOne\CodeGeneratorBundle\Command\Helper
 * @author    Chris Westerfield <chris@mjr.one>
 * @author Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class GenerateCommandCommand extends GeneratorCommandAbstract
{
    const MAX_ATTEMPTS = 5;

    /**
     * @see Command
     */
    public function configure()
    {
        $this->setName('mjr:generateCommand')
             ->setDescription('Generates a console command')
             ->setDefinition(
                 [
                     new InputArgument(
                         'bundle',
                         InputArgument::OPTIONAL,
                         'The bundle where the command is generated'
                     ),
                     new InputArgument(
                         'name',
                         InputArgument::OPTIONAL,
                         'The command\'s name (e.g. app:my-command)'
                     ),
                 ]
             );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null
     * @throws \RuntimeException
     */
    public function interact(InputInterface $input, OutputInterface $output)
    {
        $bundle = $input->getArgument('bundle');
        $name = $input->getArgument('name');

        if (null !== $bundle && null !== $name)
        {
            return null;
        }

        $questionHelper = $this->getQuestionHelper();
        $questionHelper->printSection($output, 'Welcome to the MJRONE command generator');

        // bundle
        if (null !== $bundle)
        {
            $output->writeln(sprintf('Bundle name: %s', $bundle));
        }
        else
        {
            $output->writeln(
                [
                    '',
                    'First, you need to give the name of the bundle where the command will',
                    'be generated (e.g. <comment>AppBundle</comment>)',
                    '',
                ]
            );

            $bundleNames = array_keys($this->getContainer()->get('kernel')->getBundles());

            $question = new Question($questionHelper->getQuestion('Bundle name', $bundle), $bundle);
            $question->setAutocompleterValues($bundleNames);
            $question->setValidator(
                function ($answer) use ($bundleNames)
                {
                    if (!in_array($answer, $bundleNames))
                    {
                        throw new RuntimeException(sprintf('Bundle "%s" does not exist.', $answer));
                    }

                    return $answer;
                }
            );
            $question->setMaxAttempts(self::MAX_ATTEMPTS);

            $bundle = $questionHelper->ask($input, $output, $question);
            $input->setArgument('bundle', $bundle);
        }

        // command name
        if (null !== $name)
        {
            $output->writeln(sprintf('Command name: %s', $name));
        }
        else
        {
            $output->writeln(
                array(
                    '',
                    'Now, provide the name of the command as you type it in the console',
                    '(e.g. <comment>app:my-command</comment>)',
                    '',
                )
            );

            $question = new Question($questionHelper->getQuestion('Command name', $name), $name);
            $question->setValidator(
                function ($answer)
                {
                    if (empty($answer))
                    {
                        throw new RuntimeException('The command name cannot be empty.');
                    }

                    return $answer;
                }
            );
            $question->setMaxAttempts(self::MAX_ATTEMPTS);

            $name = $questionHelper->ask($input, $output, $question);
            $input->setArgument('name', $name);
        }

        // summary and confirmation
        $output->writeln(
            array(
                '',
                $this->getHelper('formatter')->formatBlock('Summary before generation', 'bg=blue;fg-white', true),
                '',
                sprintf(
                    'You are going to generate a <info>%s</info> command inside <info>%s</info> bundle.', $name, $bundle
                ),
            )
        );

        $question = new Question($questionHelper->getQuestion('Do you confirm generation', 'yes', '?'), true);
        if (!$questionHelper->ask($input, $output, $question))
        {
            $output->writeln('<error>Command aborted</error>');

            return 1;
        }
        return 0;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        $bundle = $input->getArgument('bundle');
        $name = $input->getArgument('name');

        try
        {
            $bundle = $this->getContainer()->get('kernel')->getBundle($bundle);
        } catch (\Exception $e)
        {
            $output->writeln(sprintf('<bg=red>Bundle "%s" does not exist.</>', $bundle));
        }
        /** @var CommandGenerator $generator */
        $generator = $this->getGenerator($bundle);
        $generator->generate($bundle, $name);

        $output->writeln(
            sprintf('Generated the <info>%s</info> command in <info>%s</info>', $name, $bundle->getName())
        );
        $questionHelper->printOperationSummary($output, array());
    }

    /**
     * @return CommandGenerator|GeneratorInterface
     * @throws \LogicException
     */
    protected function createGenerator():GeneratorInterface
    {
        return $this->getContainer()->get('mjrone.codegenerator.generator.command');
    }
}
