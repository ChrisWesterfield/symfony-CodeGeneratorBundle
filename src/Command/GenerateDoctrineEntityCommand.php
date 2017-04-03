<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Command;

use bar\baz\source_with_namespace;
use InvalidArgumentException;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Command\Helper\GeneratorCommandAbstract;
use MjrOne\CodeGeneratorBundle\Command\Helper\QuestionHelper;
use MjrOne\CodeGeneratorBundle\Generator\DoctrineEntityGenerator;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorDriverInterface;
use MjrOne\CodeGeneratorBundle\Validator\BundleValidation;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Console\Question\Question;
use Doctrine\DBAL\Types\Type;

/**
 * Class GenerateDoctrineEntityCommand
 *
 * @package   MjrOne\CodeGeneratorBundle\Command
 * @package   MjrOne\CodeGeneratorBundle\Command\Helper
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class GenerateDoctrineEntityCommand extends GeneratorCommandAbstract
{
    const REGEX_FIELD      = '{(?:\([^\(]*\))(*SKIP)(*F)|\s+}';
    const REGEX_ATTRIBUTES = '{([^,= ]+)=([^,= ]+)}';

    protected function configure()
    {
        $this
            ->setName('mjr:generateEntity')
            ->setDescription('Generates a new Doctrine entity inside a bundle')
            ->addOption(
                'entity',
                'y',
                InputOption::VALUE_REQUIRED,
                'The entity class name to initialize (shortcut notation)'
            )
            ->addOption(
                'fields',
                's',
                InputOption::VALUE_REQUIRED,
                'The fields to create with the new entity'
            )
            ->addOption(
                'format',
                'f',
                InputOption::VALUE_REQUIRED,
                'Use the format for configuration files (php, xml, yml, or annotation)', 'annotation'
            );
    }

    /**
     * @throws \InvalidArgumentException When the bundle doesn't end with Bundle (Example: "Bundle/MySampleBundle")
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        $validator = $this->getContainer()->get('mjrone.codegenerator.validatior.bundle');
        $entity = $validator->validateEntityName($input->getOption('entity'));
        list($bundle, $entity) = $this->parseShortcutNotation($entity);
        $format = $validator->validateFormat($input->getOption('format'));
        $fields = $this->parseFields($input->getOption('fields'));

        $questionHelper->printSection($output, 'Entity generation');

        $bundle = $this->getContainer()->get('kernel')->getBundle($bundle);

        /** @var DoctrineEntityGenerator $generator */
        $generator = $this->getGenerator();
        $generatorResult = $generator->generate($bundle, $entity, $format, array_values($fields));

        $output->writeln(
            sprintf(
                '> Generating entity class <info>%s</info>: <comment>OK!</comment>',
                $this->makePathRelative($generatorResult->getEntityPath())
            )
        );
        $output->writeln(
            sprintf(
                '> Generating repository class <info>%s</info>: <comment>OK!</comment>',
                $this->makePathRelative($generatorResult->getRepositoryPath())
            )
        );
        if ($generatorResult->getMappingPath())
        {
            $output->writeln(
                sprintf(
                    '> Generating mapping file <info>%s</info>: <comment>OK!</comment>',
                    $this->makePathRelative($generatorResult->getMappingPath())
                )
            );
        }

        $questionHelper->printOperationSummary($output, array());
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \LogicException
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        $questionHelper->printSection($output, 'Welcome to the MJR.ONE Doctrine2 entity generator');

        // namespace
        $output->writeln(
            array(
                '',
                'This command helps you generate Doctrine2 entities.',
                '',
                'First, you need to give the entity name you want to generate.',
                'You must use the shortcut notation like <comment>AcmeBlogBundle:Post</comment>.',
                '',
            )
        );

        $bundleNames = array_keys($this->getContainer()->get('kernel')->getBundles());

        $bundle = null;
        $entity = null;
        /** @var BundleValidation $validator */
        $validator = $this->getContainer()->get('mjrone.codegenerator.validatior.bundle');

        while (true)
        {
            $question = new Question(
                $questionHelper->getQuestion('The Entity shortcut name', $input->getOption('entity')),
                $input->getOption('entity')
            );
            $question->setValidator(
                function($entity) use ($validator)
                {
                    return $validator->validateEntityName($entity);
                }
            );
            $question->setAutocompleterValues($bundleNames);
            $entity = $questionHelper->ask($input, $output, $question);

            list($bundle, $entity) = $this->parseShortcutNotation($entity);

            // check reserved words
            if ($this->getGenerator()->isReservedKeyword($entity))
            {
                $output->writeln(sprintf('<bg=red> "%s" is a reserved word</>.', $entity));
                continue;
            }

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
        $input->setOption('entity', $bundle . ':' . $entity);

        // format
        $output->writeln(
            [
                '',
                'Determine the format to use for the mapping information.',
                '',
            ]
        );

        $formats = array('yml', 'xml', 'php', 'annotation');

        $question = new Question(
            $questionHelper->getQuestion
            (
                'Configuration format (yml, xml, php, or annotation)',
                $input->getOption('format')
            ),
            $input->getOption('format')
        );
        $question->setValidator(
            function($format) use ($validator)
            {
                return $validator->validateFormat($format);
            }
        );
        $question->setAutocompleterValues($formats);
        $format = $questionHelper->ask($input, $output, $question);
        $input->setOption('format', $format);

        // fields
        $input->setOption('fields', $this->addFields($input, $output, $questionHelper));
    }

    protected function parseFields($input)
    {
        if($input===null)
        {
            return [];
        }
        if (is_array($input))
        {
            return $input;
        }

        $fields = array();
        foreach (preg_split(self::REGEX_FIELD, $input) as $value)
        {
            $elements = explode(':', $value);
            $name = $elements[0];
            $fieldAttributes = array();
            if (strlen($name))
            {
                $fieldAttributes['fieldName'] = $name;
                $type = $elements[1] ?? 'string';
                preg_match_all('{(.*)\((.*)\)}', $type, $matches);
                $fieldAttributes['type'] = $matches[1][0] ?? $type;
                $length = null;
                if ('string' === $fieldAttributes['type'])
                {
                    $fieldAttributes['length'] = $length;
                }
                if (isset($matches[2][0]) && $length = $matches[2][0])
                {
                    $attributesFound = array();
                    if (false !== strpos($length, '='))
                    {
                        preg_match_all(self::REGEX_ATTRIBUTES, $length, $result);
                        $attributesFound = array_combine($result[1], $result[2]);
                    }
                    else
                    {
                        $fieldAttributes['length'] = $length;
                    }
                    $fieldAttributes = array_merge($fieldAttributes, $attributesFound);
                    foreach (
                        [
                            'length',
                            'precision',
                            'scale',
                        ] as $intAttribute
                    )
                    {
                        if (isset($fieldAttributes[$intAttribute]))
                        {
                            $fieldAttributes[$intAttribute] = (int)$fieldAttributes[$intAttribute];
                        }
                    }
                    foreach (
                        [
                            'nullable',
                            'unique',
                        ] as $boolAttribute
                    )
                    {
                        if (isset($fieldAttributes[$boolAttribute]))
                        {
                            $fieldAttributes[$boolAttribute] =
                                filter_var($fieldAttributes[$boolAttribute], FILTER_VALIDATE_BOOLEAN);
                        }
                    }
                }

                $fields[$name] = $fieldAttributes;
            }
        }

        return $fields;
    }

    /**
     * @param InputInterface        $input
     * @param OutputInterface       $output
     * @param Helper\QuestionHelper $questionHelper
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    private function addFields(InputInterface $input, OutputInterface $output, QuestionHelper $questionHelper)
    {
        $fields = $this->parseFields($input->getOption('fields'));
        $output->writeln(
            [
                '',
                'Instead of starting with a blank entity, you can add some fields now.',
                'Note that the primary key will be added automatically (named <comment>id</comment>).',
                '',
            ]
        );
        $output->write('<info>Available types:</info> ');

        $types = array_keys(Type::getTypesMap());
        $count = 20;
        foreach ($types as $i => $type)
        {
            if ($count > 50)
            {
                $count = 0;
                $output->writeln('');
            }
            $count += strlen($type);
            $output->write(sprintf('<comment>%s</comment>', $type));
            if (count($types) != $i + 1)
            {
                $output->write(', ');
            }
            else
            {
                $output->write('.');
            }
        }
        $output->writeln('');

        $fieldValidator = function ($type) use ($types)
        {
            if (!in_array($type, $types, true))
            {
                throw new InvalidArgumentException(sprintf('Invalid type "%s".', $type));
            }

            return $type;
        };

        $lengthValidator = function ($length)
        {
            if (!$length)
            {
                return $length;
            }

            $result = filter_var(
                $length, FILTER_VALIDATE_INT, array(
                           'options' => array('min_range' => 1),
                       )
            );

            if (false === $result)
            {
                throw new InvalidArgumentException(sprintf('Invalid length "%s".', $length));
            }

            return $length;
        };

        $boolValidator = function ($value)
        {
            if (null === $valueAsBool = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))
            {
                throw new InvalidArgumentException(sprintf('Invalid bool value "%s".', $value));
            }

            return $valueAsBool;
        };

        $precisionValidator = function ($precision)
        {
            if (!$precision)
            {
                return $precision;
            }

            $result = filter_var(
                $precision, FILTER_VALIDATE_INT, array(
                              'options' => array('min_range' => 1, 'max_range' => 65),
                          )
            );

            if (false === $result)
            {
                throw new InvalidArgumentException(sprintf('Invalid precision "%s".', $precision));
            }

            return $precision;
        };

        $scaleValidator = function ($scale)
        {
            if (!$scale)
            {
                return $scale;
            }

            $result = filter_var(
                $scale, FILTER_VALIDATE_INT, array(
                          'options' => array('min_range' => 0, 'max_range' => 30),
                      )
            );

            if (false === $result)
            {
                throw new InvalidArgumentException(sprintf('Invalid scale "%s".', $scale));
            }

            return $scale;
        };

        while (true)
        {
            $output->writeln('');
            $generator = $this->getGenerator();
            $question = new Question(
                $questionHelper->getQuestion('New field name (press <return> to stop adding fields)', null), null
            );
            $question->setValidator(
                function ($name) use ($fields, $generator)
                {
                    /** @var DoctrineEntityGenerator $generator */
                    if (isset($fields[$name]) || 'id' === $name)
                    {
                        throw new InvalidArgumentException(sprintf('Field "%s" is already defined.', $name));
                    }

                    // check reserved words
                    if ($generator->isReservedKeyword($name))
                    {
                        throw new InvalidArgumentException(sprintf('Name "%s" is a reserved word.', $name));
                    }

                    // check for valid PHP variable name
                    if (!is_null($name) && !$generator->isValidPhpVariableName($name))
                    {
                        throw new InvalidArgumentException(sprintf('"%s" is not a valid PHP variable name.', $name));
                    }

                    return $name;
                }
            );

            $columnName = $questionHelper->ask($input, $output, $question);
            if (!$columnName)
            {
                break;
            }

            $defaultType = 'string';

            // try to guess the type by the column name prefix/suffix
            if (substr($columnName, -3) === '_at')
            {
                $defaultType = 'datetime';
            }
            elseif (substr($columnName, -3) === '_id')
            {
                $defaultType = 'integer';
            }
            elseif (substr($columnName, 0, 3) === 'is_')
            {
                $defaultType = 'boolean';
            }
            elseif (substr($columnName, 0, 4) === 'has_')
            {
                $defaultType = 'boolean';
            }

            $question = new Question($questionHelper->getQuestion('Field type', $defaultType), $defaultType);
            $question->setValidator($fieldValidator);
            $question->setAutocompleterValues($types);
            $type = $questionHelper->ask($input, $output, $question);

            $data = array(
                'columnName' => $columnName, 'fieldName' => lcfirst(Container::camelize($columnName)), 'type' => $type,
            );

            if ($type === 'string')
            {
                $question = new Question($questionHelper->getQuestion('Field length', 255), 255);
                $question->setValidator($lengthValidator);
                $data['length'] = $questionHelper->ask($input, $output, $question);
            }
            elseif ('decimal' === $type)
            {
                // 10 is the default value given in \Doctrine\DBAL\Schema\Column::$_precision
                $question = new Question($questionHelper->getQuestion('Precision', 10), 10);
                $question->setValidator($precisionValidator);
                $data['precision'] = $questionHelper->ask($input, $output, $question);

                // 0 is the default value given in \Doctrine\DBAL\Schema\Column::$_scale
                $question = new Question($questionHelper->getQuestion('Scale', 0), 0);
                $question->setValidator($scaleValidator);
                $data['scale'] = $questionHelper->ask($input, $output, $question);
            }

            $question = new Question($questionHelper->getQuestion('Is nullable', 'false'), false);
            $question->setValidator($boolValidator);
            $question->setAutocompleterValues(array('true', 'false'));
            if ($nullable = $questionHelper->ask($input, $output, $question))
            {
                $data['nullable'] = $nullable;
            }

            $question = new Question($questionHelper->getQuestion('Unique', 'false'), false);
            $question->setValidator($boolValidator);
            $question->setAutocompleterValues(array('true', 'false'));
            if ($unique = $questionHelper->ask($input, $output, $question))
            {
                $data['unique'] = $unique;
            }

            $fields[$columnName] = $data;
        }

        return $fields;
    }

    /**
     * @return GeneratorDriverInterface|DoctrineEntityGenerator
     */
    protected function createGenerator(): GeneratorDriverInterface
    {
        return $this->getContainer()->get('mjrone.codegenerator.generator.entity');
    }
}
