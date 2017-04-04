<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Document\Annotation;
use MjrOne\CodeGeneratorBundle\Event\CodeGeneratorServiceConstructorEvent;
use MjrOne\CodeGeneratorBundle\Event\CodeGeneratorServiceSetFileEvent;
use MjrOne\CodeGeneratorBundle\Generator\PhpUnit\CodeGeneratorAbstract;
use MjrOne\CodeGeneratorBundle\Services\CodeGeneratorInterface;
use MjrOne\CodeGeneratorBundle\Services\ConfiguratorService;
use MjrOne\CodeGeneratorBundle\Services\EventDispatcherService;
use MjrOne\CodeGeneratorBundle\Services\ReadAnnotationService;
use MjrOne\CodeGeneratorBundle\Services\RenderService;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class CodeGeneratorService
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class CodeGenerator extends CodeGeneratorSupportAbstract implements CodeGeneratorInterface
{
    /**
     * @var ReadAnnotationService
     */
    protected $annotationService;

    /**
     * @var Annotation
     */
    protected $annotations;

    /**
     * @var ConfiguratorService
     */
    protected $config;

    /**
     * @var string
     */
    protected $file;

    /**
     * @var RenderService
     */
    protected $renderer;

    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var EventDispatcherService
     */
    protected $eventDispatcherService;

    /**
     * CodeGeneratorService constructor.
     *
     * @param ReadAnnotationService $readAnnotation
     * @param ConfiguratorService $configuration
     * @param RenderService $renderService
     * @param KernelInterface $kernel
     * @param EventDispatcherService $eventDispatcher
     */
    public function __construct(
        ReadAnnotationService $readAnnotation, ConfiguratorService $configuration, RenderService $renderService,
        KernelInterface $kernel, EventDispatcherService $eventDispatcher
    )
    {
        $this->annotationService = $readAnnotation;
        $this->config = $configuration;
        $this->renderer = $renderService;
        $this->kernel = $kernel;
        $this->eventDispatcherService = $eventDispatcher;
        $event = (new CodeGeneratorServiceConstructorEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'constructor'), $event);
    }

    /**
     * @param $file
     *
     * @return CodeGenerator
     */
    public function setFile($file): CodeGenerator
    {
        /** @var CodeGeneratorServiceSetFileEvent $event */
        $event = (new CodeGeneratorServiceSetFileEvent())->setFile($file)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'setFile'), $event);
        $file = $event->getFile();
        $this->file = $file;

        return $this;
    }

    public function process()
    {
        $this->annotations = $this->annotationService->get($this->file);
        if ($this->annotations->getClasses()->count() > 0)
        {
            foreach ($this->annotations->getClasses() as $classAnnotation)
            {
                if ($classAnnotation instanceof CG\DriverInterface)
                {
                    $class = get_class($classAnnotation);
                    $driver = $class::DRIVER;
                    if ($driver === CG\DriverInterface::class)
                    {
                        continue;
                    }
                    /** @var CodeGeneratorInterface $instance */
                    $instance = new $driver($this->file, $classAnnotation, $this);
                    $instance->process();
                }
            }
        }
    }

    /**
     * @return ReadAnnotationService
     */
    public function getAnnotationService(): ReadAnnotationService
    {
        return $this->annotationService;
    }

    /**
     * @return Annotation
     */
    public function getAnnotations(): Annotation
    {
        return $this->annotations;
    }

    /**
     * @return ConfiguratorService
     */
    public function getConfig(): ConfiguratorService
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @return RenderService
     */
    public function getRenderer(): RenderService
    {
        return $this->renderer;
    }

    /**
     * @return KernelInterface
     */
    public function getKernel(): KernelInterface
    {
        return $this->kernel;
    }

    /**
     * @return EventDispatcherService
     */
    public function getED()
    {
        return $this->getEventDispatcher();
    }

    /**
     * @return EventDispatcherService
     */
    public function getEventDispatcher(): EventDispatcherService
    {
        return $this->eventDispatcherService;
    }
}
