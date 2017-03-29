<?php
declare(strict_types = 1); 
namespace MjrOne\CodeGeneratorBundle\Command;

use MjrOne\CodeGeneratorBundle\Command\Helper\GeneratorCommandAbstract;
use MjrOne\CodeGeneratorBundle\Generator\DoctrineFormGenerator;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorDriverInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * @package MjrOne\CodeGeneratorBundle\Command
 * @package MjrOne\CodeGeneratorBundle\Command\Helper
 * @author    Chris Westerfield <chris@mjr.one>
 * @author Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */


class GenerateDoctrineFormCommand extends GeneratorCommandAbstract
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('mjr:generateForm')
            ->setDescription('Generates a form type class based on a Doctrine entity')
            ->setDefinition(
                [
                    new InputArgument(
                        'entity',
                        InputArgument::REQUIRED,
                        'The entity class name to initialize (shortcut notation)'
                    ),
                ]
            );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null|void
     * @throws \Doctrine\ORM\Mapping\MappingException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        $entity = $this
            ->getContainer()
            ->get('mjrone.codegenerator.validatior.bundle')
            ->validateEntityName($input->getArgument('entity'));

        list($bundle, $entity) = $this->parseShortcutNotation($entity);

        $entityClass = $this->getContainer()->get('doctrine')->getAliasNamespace($bundle).'\\'.$entity;
        $metadata = $this->getEntityMetadata($entityClass);
        $bundleObject = $this->getContainer()->get('kernel')->getBundle($bundle);
        /** @var DoctrineFormGenerator $generator */
        $generator = $this->getGenerator($bundleObject);

        $generator->generate($bundleObject, $entity, $metadata[0]);

        $output->writeln(
            sprintf(
             'The new %s.php class file has been created under %s.',
             $generator->getClassName(),
             $generator->getClassPath()
            )
        );
    }



    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        $questionHelper->printSection($output, 'Welcome to the MJR.ONE Doctrine2 Form generator');
        /** @var array $bundleNames */
        $bundleNames = array_keys($this->getContainer()->get('kernel')->getBundles());
        $bundle = $entityShort = null;
        while (true)
        {
            $entityName =
            $question = new Question(
                $questionHelper->getQuestion(
                    'The Entity shortcut name',
                    $input->getArgument('entity')
                ),
                $input->getArgument('entity')
            );
            $question->setValidator(array('Sensio\Bundle\GeneratorBundle\Command\Validators', 'validateEntityName'));
            $question->setAutocompleterValues($bundleNames);
            $entity = $questionHelper->ask($input, $output, $question);

            list($bundle, $entityShort) = $this->parseShortcutNotation($entity);

            try
            {
                $b = $this->getContainer()->get('kernel')->getBundle($bundle);

                if (!file_exists($b->getPath() . '/Entity/' . str_replace('\\', '/', $entity) . '.php'))
                {
                    break;
                }

                $output->writeln(sprintf('<bg=red>Entity "%s:%s" already exists</>.', $bundle, $entity));
            } catch (\Exception $e)
            {
                $output->writeln(sprintf('<bg=red>Bundle "%s" does not exist.</>', $bundle));
            }
        }
        $input->setArgument('entity',$bundle.':'.$entityShort);

    }

        /**
     * @return \MjrOne\CodeGeneratorBundle\Generator\GeneratorDriverInterface
     * @throws \LogicException
     */
    protected function createGenerator():GeneratorDriverInterface
    {
        return $this->getContainer()->get('mjrone.codegenerator.generator.form');
    }
}

