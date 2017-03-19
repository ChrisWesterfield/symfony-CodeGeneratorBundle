<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 13/03/2017
 * Time: 21:29
 */

namespace MjrOne\CodeGeneratorBundle\Services;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Document\Annotation;
use MjrOne\CodeGeneratorBundle\Event\CodeGeneratorServiceConstructorEvent;
use MjrOne\CodeGeneratorBundle\Event\CodeGeneratorServiceSetFileEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class CodeGeneratorService extends AbstractService implements CodeGeneratorInterface
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
     * @var ConfigurationService
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
     * @param ReadAnnotationService  $readAnnotation
     * @param ConfigurationService   $configuration
     * @param RenderService          $renderService
     * @param KernelInterface        $kernel
     * @param EventDispatcherService $eventDispatcher
     */
    public function __construct(ReadAnnotationService $readAnnotation, ConfigurationService $configuration, RenderService $renderService, KernelInterface $kernel, EventDispatcherService $eventDispatcher)
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
     * @return CodeGeneratorService
     */
    public function setFile($file):CodeGeneratorService
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
        if($this->annotations->getClasses()->count() > 0)
        {
            foreach($this->annotations->getClasses() as $classAnnotation)
            {
                if($classAnnotation instanceof CG\DriverInterface)
                {
                    $class = get_class($classAnnotation);
                    $driver = $class::DRIVER;
                    if($driver === CG\DriverInterface::class)
                    {
                        continue;
                    }
                    /** @var CG\ClassInterface $instance */
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
     * @return ConfigurationService
     */
    public function getConfig(): ConfigurationService
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
