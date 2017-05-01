<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\AnnotationInterface;
use MjrOne\CodeGeneratorBundle\Document\Annotation;
use MjrOne\CodeGeneratorBundle\Event\AddToListEvent;
use MjrOne\CodeGeneratorBundle\Event\GeneratorAbstractGetBasicsPostEvent;
use MjrOne\CodeGeneratorBundle\Event\GeneratorAbstractWriteToDiskEvent;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorInterface;
use MjrOne\CodeGeneratorBundle\Services\EventDispatcherService;
use MjrOne\CodeGeneratorBundle\Generator\CodeGenerator;
use MjrOne\CodeGeneratorBundle\Services\RenderService;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class GeneratorAbstract
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
abstract class CodeGeneratorAbstract implements CodeGeneratorInterface
{
    const BUNDLE_DETECTION_NAME = 'bundle';
    const NAMESPACE_DIRECTORY_FOR_TRAITS = 'Traits/CodeGenerator';
    const FILE_EXTENSION = '.php';
    const SERVICE_FILE = 'Resources/config/services.yml';
    const SRC_DIRECTORY = 'src';
    /**
     * @var string
     */
    protected $file;

    /**
     * @var AnnotationInterface
     */
    protected $annotation;

    /**
     * @var Annotation
     */
    protected $documentAnnotation;

    /**
     * @var RenderService
     */
    protected $renderer;

    /**
     * @var CodeGenerator
     */
    protected $generator;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $fileSystem;

    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var EventDispatcherService
     */
    protected $eventDispatcher;

    /**
     * @var string
     */
    protected $rootFilePath;

    /**
     * GeneratorAbstract constructor.
     *
     * @param                                                            $file
     * @param AnnotationInterface $currentAnnotation
     * @param CodeGenerator $generator
     */
    public function __construct($file, AnnotationInterface $currentAnnotation, CodeGenerator $generator)
    {
        $this->file = $file;
        $this->annotation = $currentAnnotation;
        $this->documentAnnotation = $generator->getAnnotations();
        $this->renderer = $generator->getRenderer();
        $this->service = $generator;
        $this->kernel = $generator->getKernel();
        $this->eventDispatcher = $generator->getED();
        $this->fileSystem = new Filesystem();
        $rootBundlePath = [];
        $fileArray = explode('/', $file);
        $bundleRoot = false;
        foreach ($fileArray as $item) {
            if ($bundleRoot && strpos($item, self::SRC_DIRECTORY) === false) {
                break(1);
            }
            if (strpos(strtolower($item), self::BUNDLE_DETECTION_NAME) !== false) {
                $bundleRoot = true;
            }
            $rootBundlePath[] = $item;
        }
        $this->rootFilePath = implode('/', $rootBundlePath);
    }

    /**
     * @return string
     */
    protected function getFile(): string
    {
        return $this->file;
    }

    /**
     * @return AnnotationInterface
     */
    protected function getAnnotation(): AnnotationInterface
    {
        return $this->annotation;
    }

    /**
     * @return Annotation
     */
    protected function getDocumentAnnotation(): Annotation
    {
        return $this->documentAnnotation;
    }

    /**
     * @return RenderService
     */
    protected function getRenderer(): RenderService
    {
        return $this->renderer;
    }

    /**
     * @return CodeGenerator
     */
    protected function getGenerator(): CodeGenerator
    {
        return $this->generator;
    }

    /**
     * @param array $templateVariables
     * @param string $className
     *
     * @return array
     */
    protected function getBasics(array $templateVariables, string $className): array
    {
        $doc = $this->getDocumentAnnotation();
        $data = [
            'namespace' => $doc->getBundleRootNamespace() . '\\' . Annotation::TRAIT_NAMESPACE
                . $doc->getClassNamespacePath(),
            'class' => $className . $doc->getClassShort(),
            'usedBy' => $doc->getFqdnName(),
            'configuration' => $this->service->getConfig()->toArray(),
            'short' => $doc->getClassShort(),
            'classNameSpace' => $doc->getNamespace(),
        ];
        $event = new GeneratorAbstractGetBasicsPostEvent($this, $data, $doc);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'getBasics'), $event);
        $data = $event->getFileBasics();

        return array_merge($data, $templateVariables);
    }

    /**
     * @return \Symfony\Component\Filesystem\Filesystem
     */
    protected function getFileSystem(): \Symfony\Component\Filesystem\Filesystem
    {
        return $this->fileSystem;
    }

    /**
     * @return string
     */
    protected function getRootPath()
    {
        $path = method_exists($this->kernel, 'getRealRootDirectory') ? $this->kernel->getRealRootDirectory()
            : $this->kernel->getRootDir() . '/../';
        return realpath($path);
    }

    /**
     * @param string $file
     *
     * @return mixed
     */
    protected function getRootBundlePath(string $file)
    {
        $path = $this->getRootPath();
        $file = str_replace($path, '', $file);
        $file = explode('/', $file);
        $exitBundle = false;
        foreach ($file as $entry) {
            if ($exitBundle && $entry === self::SRC_DIRECTORY) {
                $path .= $entry;
                break(1);
            }
            if (!$exitBundle && strpos(strtolower($entry), self::BUNDLE_DETECTION_NAME) !== false) {
                $exitBundle = true;
            }
            $path .= $entry . '/';
            if($exitBundle)
            {
                break(1);
            }
        }
        $path = rtrim($path, '/');
        $namespace = $this->getDocumentAnnotation()->getNamespace();
        $namespace = str_replace($this->getDocumentAnnotation()->getBundleRootNamespace(), '', $namespace);
        $namespace = str_replace('\\', '/', $namespace);
        $path .= '/' . self::NAMESPACE_DIRECTORY_FOR_TRAITS . '/' . $namespace;

        return str_replace('//', '/', $path);
    }

    /**
     * @param string $file
     * @param string $traitPrefix
     *
     * @return array
     */
    protected function getTraitFile(string $file, string $traitPrefix): array
    {
        $traitFile =  [
            $this->getRootBundlePath($file),
            $traitPrefix . $this->getDocumentAnnotation()->getClassShort() . self::FILE_EXTENSION,
        ];
        return $traitFile;
    }

    /**
     * @param string $path
     * @param string $file
     * @param string $content
     *
     * @return bool
     */
    protected function writeToDisk(string $path, string $file, string $content): bool
    {
        $path = rtrim($path, '/');
        $event = (new GeneratorAbstractWriteToDiskEvent($this))->setName($file)->setPath($path)->setContent($content);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'writeToDisk'), $event);
        $path = $event->getPath();
        $file = $event->getName();
        $content = $event->getContent();
        if (!$this->getFileSystem()->exists($path) && $event->isCreateDirectory()) {
            $this->getFileSystem()->mkdir($path);
        }
        file_put_contents($path . '/' . $file, $content);

        return true;
    }

    /**
     * @return string
     */
    protected function getFilePath(): string
    {
        $rootPath = (method_exists($this->kernel, 'getRealRootDirectory') ? $this->kernel->getRealRootDirectory() : $this->kernel->getRootDir() . '/../');
        $path = $this->getFile();
        if (strpos($path, $rootPath) === false && $path[0] !== '/') {
            $path = $rootPath . $this->getFile();
        }
        return str_replace('//', '/', $path);
    }

    protected function checkFileForTrait($templateVars)
    {
        $path = $this->getFilePath();
        $fileContainer = $this->getKernel()->getContainer()->get('mjrone.codegenerator.php.parser.file')->readFile($path);
        $fullTrait = $templateVars['namespace'] . '\\' . $templateVars['class'];
        $shortTrait = $templateVars['class'];
        if (!$fileContainer->hasUsedNamespace($fullTrait)) {
            $fileContainer->addUsedNamespace($fullTrait);
        }
        if (!$fileContainer->hasTraitUse($shortTrait)) {
            $fileContainer->addTraitUse($shortTrait);
        }
        if ($fileContainer->isUpdateNeeded()) {
            $this->getKernel()->getContainer()->get('mjrone.codegenerator.php.writer')->writeDocument($fileContainer, $path);
        }
    }

    /**
     * @return KernelInterface
     */
    protected function getKernel(): KernelInterface
    {
        return $this->kernel;
    }

    /**
     * @return EventDispatcherService
     */
    protected function getED()
    {
        return $this->getEventDispatcher();
    }

    /**
     * @return EventDispatcherService
     */
    protected function getEventDispatcher(): EventDispatcherService
    {
        return $this->eventDispatcher;
    }

    /**
     * @return string
     */
    public function getRootFilePath(): string
    {
        return $this->rootFilePath;
    }

    public function getServiceConfigFile()
    {
        return $this->getRootFilePath() . '/' . self::SERVICE_FILE;
    }

    /**
     * @return CodeGenerator
     */
    public function getService(): CodeGenerator
    {
        return $this->service;
    }

    /**
     * @param string $class
     * @param ArrayCollection $list
     * @param string|null $alias
     */
    protected function addToList(string $class, ArrayCollection $list, string $alias = null)
    {
        $event = (new AddToListEvent())->setList($list)->setClass($class)->setAlias($alias)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'addToListPre'), $event);
        $class = $event->getClass();
        $list = $event->getList();
        $alias = $event->getAlias();
        $loc = $list->get('loc');
        $key = $class . (string)$alias;
        if (!in_array($key, $loc, true)) {
            $entry = [
                'name' => $class,
            ];
            if ($alias !== null) {
                $entry['alias'] = $alias;
            }
            $list->add($entry);
            $loc[] = $key;
            $list->set('loc', $loc);
            $event = (new AddToListEvent())->setList($list)->setClass($class)->setAlias($alias)->setSubject($this);
            $this->getED()->dispatch($this->getED()->getEventName(self::class, 'addToListInline'), $event);
            $class = $event->getClass();
            $list = $event->getList();
            $alias = $event->getAlias();
        }
        $event = (new AddToListEvent())->setList($list)->setClass($class)->setAlias($alias)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'addToListPost'), $event);
    }

    protected function getServiceName()
    {
        $className = $this->getDocumentAnnotation()->getFqdnName();
        $serviceName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
        $serviceName = str_replace(['\\', '._'], '.', $serviceName);

        return trim($serviceName, '.');
    }

    /**
     * @param $config
     */
    protected function processServiceConfig($config)
    {
        $yml = Yaml::dump($config, 100);
        $this->getFileSystem()->dumpFile($this->getServiceConfigFile(), $yml);
    }
}
