<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator;

use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Mapping\MappingException;
use Doctrine\ORM\Tools\EntityGenerator;
use Doctrine\ORM\Tools\EntityRepositoryGenerator;
use Doctrine\ORM\Tools\Export\ClassMetadataExporter;
use Doctrine\ORM\Tools\Export\ExportException;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Document\Entity;
use MjrOne\CodeGeneratorBundle\Event\DoctrineEntityGeneratorContentEvent;
use MjrOne\CodeGeneratorBundle\Services\ConfiguratorService;
use MjrOne\CodeGeneratorBundle\Services\EventDispatcherService;
use RuntimeException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig_Environment;

/**
 * Class DoctrineEntityGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator
 * @author    Chris Westerfield <chris@mjr.one>
 * @author    Fabien Potencier <fabien@symfony.com>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class DoctrineEntityGenerator extends GeneratorAbstract
{
    /**
     * @var RegistryInterface
     */
    protected $registry;

    /**
     * @var EventDispatcherService
     */
    protected $event;

    /**
     * GeneratorAbstract constructor.
     *
     * @param Twig_Environment       $twig
     * @param ConfiguratorService    $configuration
     * @param KernelInterface        $kernel
     * @param RegistryInterface      $registry
     * @param EventDispatcherService $eventDispatcher
     */
    public function __construct(
        Twig_Environment $twig, ConfiguratorService $configuration, KernelInterface $kernel,
        RegistryInterface $registry, EventDispatcherService $eventDispatcher
    )
    {
        parent::__construct($twig, $configuration, $kernel);
        $this->registry = $registry;
        $this->event = $eventDispatcher;
    }
    /** @noinspection MoreThanThreeArgumentsInspection */

    /**
     * @param BundleInterface $bundle
     * @param string          $entity
     * @param string          $format
     * @param array           $fields
     *
     * @return Entity
     * @throws MappingException
     * @throws RuntimeException
     *
     * @throws ExportException
     */
    public function generate(BundleInterface $bundle, $entity, $format, array $fields): Entity
    {
        // configure the bundle (needed if the bundle does not contain any Entities yet)
        /** @var \Doctrine\ORM\EntityManager $orm */
        $orm = $this->registry->getManager(null);
        $config = $orm->getConfiguration();
        $config->setEntityNamespaces(
            array_merge(
                [$bundle->getName() => $bundle->getNamespace() . '\\Entity'],
                $config->getEntityNamespaces()
            )
        );

        $entityClass = $this->registry->getAliasNamespace($bundle->getName()) . '\\' . $entity;
        $entityPath = $bundle->getPath() . '/Entity/' . str_replace('\\', '/', $entity) . '.php';
        if (file_exists($entityPath))
        {
            throw new RuntimeException(sprintf('Entity "%s" already exists.', $entityClass));
        }

        $class = new ClassMetadataInfo($entityClass, $config->getNamingStrategy());
        $class->customRepositoryClassName = str_replace('\\Entity\\', '\\Repository\\', $entityClass) . 'Repository';
        $class->mapField(
            [
                'fieldName' => 'id',
                'type'      => 'integer',
                'id'        => true,
            ]
        );
        $class->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);
        foreach ($fields as $field)
        {
            $class->mapField($field);
        }

        $entityGenerator = $this->getEntityGenerator();
        if ('annotation' === $format)
        {
            $entityGenerator->setGenerateAnnotations(true);
            $class->setPrimaryTable(array('name' => Inflector::tableize(str_replace('\\', '', $entity))));
            $entityCode = $entityGenerator->generateEntityClass($class);
            $mappingPath = $mappingCode = false;
        }
        else
        {
            $cme = new ClassMetadataExporter();
            $exporter = $cme->getExporter('yml' === $format ? 'yaml' : $format);
            $mappingPath =
                $bundle->getPath() . '/Resources/config/doctrine/' . str_replace('\\', '.', $entity) . '.orm.'
                . $format;

            if (file_exists($mappingPath))
            {
                throw new RuntimeException(
                    sprintf('Cannot generate entity when mapping "%s" already exists.', $mappingPath)
                );
            }

            $mappingCode = $exporter->exportClassMetadata($class);
            $entityGenerator->setGenerateAnnotations(false);
            $entityCode = $entityGenerator->generateEntityClass($class);
        }
        $entityCode = str_replace(
            [
                "@var integer\n",
                "@var boolean\n",
                "@param integer\n",
                "@param boolean\n",
                "@return integer\n",
                "@return boolean\n",
            ],
            [
                "@var int\n",
                "@var bool\n",
                "@param int\n",
                "@param bool\n",
                "@return int\n",
                "@return bool\n",
            ],
            $entityCode
        );

        $this->mkdir(dirname($entityPath));

        $event = (new DoctrineEntityGeneratorContentEvent())->setSubject($this)->setContent($entityCode);
        $this->event->dispatch($this->event->getEventName(self::class, 'entity'), $event);

        $this->dump($entityPath, $event->getContent());

        if ($mappingPath)
        {
            $this->mkdir(dirname($mappingPath));
            $this->dump($mappingPath, $mappingCode);
        }

        $path = $bundle->getPath() . str_repeat('/..', substr_count(get_class($bundle), '\\'));
        $this->getRepositoryGenerator()->writeEntityRepositoryClass(
            $class->customRepositoryClassName,
            $path
        );
        $repositoryPath =
            $path . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class->customRepositoryClassName)
            . '.php';

        $event = (new DoctrineEntityGeneratorContentEvent())->setSubject($this)->setContent(file_get_contents($repositoryPath));
        $this->event->dispatch($this->event->getEventName(self::class, 'repository'), $event);
        $this->getFileSystem()->dumpFile($repositoryPath,$event->getContent());
        return new Entity($entityPath, $repositoryPath, $mappingPath);
    }

    /**
     * @param $keyword
     *
     * @return bool
     */
    public function isReservedKeyword($keyword): bool
    {
        return $this->registry->getConnection()->getDatabasePlatform()->getReservedKeywordsList()->isKeyword($keyword);
    }

    /**
     * @return EntityGenerator
     */
    protected function getEntityGenerator(): EntityGenerator
    {
        $entityGenerator = new EntityGenerator();
        $entityGenerator->setGenerateAnnotations(false);
        $entityGenerator->setGenerateStubMethods(true);
        $entityGenerator->setRegenerateEntityIfExists(false);
        $entityGenerator->setUpdateEntityIfExists(true);
        $entityGenerator->setNumSpaces(4);
        $entityGenerator->setAnnotationPrefix('ORM\\');

        return $entityGenerator;
    }

    /**
     * @return EntityRepositoryGenerator
     */
    protected function getRepositoryGenerator(): EntityRepositoryGenerator
    {
        return new EntityRepositoryGenerator();
    }

    /**
     * Checks if the given name is a valid PHP variable name.
     *
     * @see http://php.net/manual/en/language.variables.basics.php
     *
     * @param $name string
     *
     * @return bool
     */
    public function isValidPhpVariableName($name)
    {
        return (bool)preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $name, $matches);
    }
}
