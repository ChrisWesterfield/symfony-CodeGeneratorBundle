<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\ConfiguratorService;
use RuntimeException;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Twig_Environment;

/**
 * Class DoctrineFormGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class DoctrineFormGenerator extends GeneratorAbstract
{
    const BUNDLE_TWIG_NAMESPACE = 'MjrOneCodeGeneratorBundle:Form:';
    /**
     * @var string
     */
    protected $className;
    /**
     * @var string
     */
    protected $classPath;

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getClassPath(): string
    {
        return $this->classPath;
    }/** @noinspection MoreThanThreeArgumentsInspection */

    /**
     * Generates the entity form class.
     *
     * @param BundleInterface   $bundle         The bundle in which to create the class
     * @param string            $entity         The entity relative class name
     * @param ClassMetadataInfo $metadata       The entity metadata class
     * @param bool              $forceOverwrite If true, remove any existing form class before generating it again
     *
     * @throws RuntimeException
     * @return void
     */
    public function generate(BundleInterface $bundle, $entity, ClassMetadataInfo $metadata, $forceOverwrite = false
    ): void
    {
        $parts = explode('\\', $entity);
        $entityClass = array_pop($parts);

        $this->className = $entityClass . 'Type';
        $dirPath = $bundle->getPath() . '/Form';
        $this->classPath = $dirPath . '/' . str_replace('\\', '/', $entity) . 'Type.php';

        if (!$forceOverwrite && file_exists($this->classPath))
        {
            throw new RuntimeException(
                sprintf(
                    'Unable to generate the %s form class as it already exists under the %s file', $this->className,
                    $this->classPath
                )
            );
        }

        if (count($metadata->identifier) > 1)
        {
            throw new RuntimeException(
                'The form generator does not support entity classes with multiple primary keys.'
            );
        }

        $parts = explode('\\', $entity);
        array_pop($parts);

        $fields = [];
        $useClasses = [];
        $fieldSets = $this->getFieldsFromMetadata($metadata);
        foreach ($fieldSets as $fieldSet)
        {
            $entry = [
                'name'     => $fieldSet,
                'type'     => null,
                'required' => null,
            ];
            switch ($metadata->getTypeOfField($fieldSet))
            {
                case 'integer':
                case 'smallint':
                case 'decimal':
                case 'bigint':
                case 'float':
                    $reflection = new \ReflectionClass(NumberType::class);
                    if (!in_array($reflection->getName(), $useClasses, true))
                    {
                        $useClasses[] = $reflection->getName();
                    }
                    $entry['type'] = $reflection->getShortName();
                    $entry['required'] = !$metadata->isNullable($fieldSet);
                    break;
                case 'text':
                    $reflection = new \ReflectionClass(TextareaType::class);
                    if (!in_array($reflection->getName(), $useClasses, true))
                    {
                        $useClasses[] = $reflection->getName();
                    }
                    $entity['type'] = $reflection->getShortName();
                    $entry['required'] = !$metadata->isNullable($fieldSet);
                    break;
                case 'string':
                    $reflection = new \ReflectionClass(TextType::class);
                    if (!in_array($reflection->getName(), $useClasses, true))
                    {
                        $useClasses[] = $reflection->getName();
                    }
                    $entry['type'] = $reflection->getShortName();
                    $entry['required'] = !$metadata->isNullable($fieldSet);
                    break;
                case 'boolean':
                    $reflection = new \ReflectionClass(CheckboxType::class);
                    if (!in_array($reflection->getName(), $useClasses, true))
                    {
                        $useClasses[] = $reflection->getName();
                    }
                    $entry['type'] = $reflection->getShortName();
                    $entry['required'] = !$metadata->isNullable($fieldSet);
                    break;
                case 'date':
                    $reflection = new \ReflectionClass(DateType::class);
                    if (!in_array($reflection->getName(), $useClasses, true))
                    {
                        $useClasses[] = $reflection->getName();
                    }
                    $entry['type'] = $reflection->getShortName();
                    $entry['required'] = !$metadata->isNullable($fieldSet);
                    break;
                case 'time':
                    $reflection = new \ReflectionClass(TimeType::class);
                    if (!in_array($reflection->getName(), $useClasses, true))
                    {
                        $useClasses[] = $reflection->getName();
                    }
                    $entry['type'] = $reflection->getShortName();
                    $entry['required'] = !$metadata->isNullable($fieldSet);
                    break;
                case 'datetime':
                case 'datetimetz':
                    $reflection = new \ReflectionClass(DateTimeType::class);
                    if (!in_array($reflection->getName(), $useClasses, true))
                    {
                        $useClasses[] = $reflection->getName();
                    }
                    $entry['type'] = $reflection->getShortName();
                    $entry['required'] = !$metadata->isNullable($fieldSet);
                    break;
            }
            $fields[] = $entry;
        }

        $parameters = [
            'fields'            => $fields,
            'namespace'         => $bundle->getNamespace(),
            'entity_namespace'  => implode('\\', $parts),
            'entity_class'      => $entityClass,
            'bundle'            => $bundle->getName(),
            'form_class'        => $this->className,
            'form_type_name'    => strtolower(
                str_replace('\\', '_', $bundle->getNamespace()) . ($parts ? '_' : '') . implode('_', $parts) . '_'
                . substr($this->className, 0, -4)
            ),
            // BC with Symfony 2.7
            'get_name_required' => !method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix'),
            'configuration'     => $this->getConfiguration()->toArray(),
            'usedClasses'       => $useClasses,
        ];

        $this->renderFile(
            self::BUNDLE_TWIG_NAMESPACE . 'formType.php.twig',
            $this->classPath,
            $parameters
        );
    }

    /**
     * @param ClassMetadataInfo $metadata
     *
     * @return array $fields
     */
    private function getFieldsFromMetadata(ClassMetadataInfo $metadata): array
    {
        $fields = (array)$metadata->fieldNames;

        // Remove the primary key field if it's not managed manually
        if (!$metadata->isIdentifierNatural())
        {
            $fields = array_diff($fields, $metadata->identifier);
        }

        foreach ($metadata->associationMappings as $fieldName => $relation)
        {
            if ($relation['type'] !== ClassMetadataInfo::ONE_TO_MANY)
            {
                $fields[] = $fieldName;
            }
        }

        return $fields;
    }
}
