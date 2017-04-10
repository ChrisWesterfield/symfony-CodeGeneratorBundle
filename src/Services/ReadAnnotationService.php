<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Services;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Document\Annotation;
use MjrOne\CodeGeneratorBundle\Event\ReadAnnotationServiceClassAnnotationsEvent;
use MjrOne\CodeGeneratorBundle\Event\ReadAnnotationServiceGetClassFromFileEvent;
use MjrOne\CodeGeneratorBundle\Event\ReadAnnotationServicePropertiesEvent;
use MjrOne\CodeGeneratorBundle\Event\ReadAnnotationServiceConstructorEvent;
use MjrOne\CodeGeneratorBundle\Event\ReadAnnotationServiceReflectionClassEvent;
use MjrOne\CodeGeneratorBundle\Event\ReadAnnotationServiceReflectionPropertyEvent;
use MjrOne\CodeGeneratorBundle\Exception\FileDoesNotExistException;
use ReflectionMethod;
use ReflectionProperty;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class ReadAnnotation
 *
 * @package   MjrOne\CodeGeneratorBundle\Services
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class ReadAnnotationService
{
    /**
     * @var AnnotationReader
     */
    protected $annotationReader;
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $fileSystem;

    /**
     * @var \MjrOne\CodeGeneratorBundle\Document\Annotation
     */
    protected $annotationsPrototype;

    /**
     * @var EventDispatcherService
     */
    protected $eventDispatcherService;

    /**
     * ReadAnnotationService constructor.
     *
     * @param EventDispatcherService $eventDispatcher
     */
    public function __construct(EventDispatcherService $eventDispatcher)
    {
        $this->eventDispatcherService = $eventDispatcher;
        $this->annotationReader = new AnnotationReader();
        $this->fileSystem = new Filesystem();
        $this->annotationsPrototype = new Annotation($this->getED());
        $event = (new ReadAnnotationServiceConstructorEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'constructor'), $event);
    }

    public function get($file)
    {
        if (!$this->fileSystem->exists($file))
        {
            throw new FileDoesNotExistException('The File ' . $file . ' could not be found!');
        }
        $annotations = clone $this->annotationsPrototype;
        $class = $this->getClassFormFile($file);

        /** @var ReadAnnotationServiceReflectionClassEvent $eventReflCl */
        $eventReflCl =
            (new ReadAnnotationServiceReflectionClassEvent())->setReflectionClass(new \ReflectionClass($class))
                                                             ->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'setReflection'), $eventReflCl);
        $annotations->setReflectionClass($eventReflCl->getReflectionClass());

        /** @var ReadAnnotationServiceClassAnnotationsEvent $eventAnnotation */
        $eventAnnotation = (new ReadAnnotationServiceClassAnnotationsEvent())->setAnnotations(
            $this->annotationReader->getClassAnnotations($annotations->getReflectionClass())
        )->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'setRawClassAnnotation'), $eventAnnotation);
        $annotations->setRawClassAnnotations($eventAnnotation->getAnnotations());

        /** @var ReadAnnotationServicePropertiesEvent $eventProperty */
        $eventProperty = (new ReadAnnotationServicePropertiesEvent())->setProperties(
            new ArrayCollection($annotations->getReflectionClass()->getProperties())
        )->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'getProperties'), $eventProperty);

        if ($eventProperty->getProperties()->count() > 0)
        {
            foreach ($eventProperty->getProperties() as $property)
            {
                /** @var ReadAnnotationServiceReflectionPropertyEvent $eventReflectionProperty */
                $eventReflectionProperty = (new ReadAnnotationServiceReflectionPropertyEvent())->setReflectionProperty(
                    new ReflectionProperty($property->getDeclaringClass()->getName(), $property->getName())
                )->setSubject($this);
                $this->getED()->dispatch(
                    $this->getED()->getEventName(self::class, 'readPropertyReflection'), $eventReflectionProperty
                );
                $annotations->addPropertyAnnotation(
                    $property->getName(), $this->annotationReader->getPropertyAnnotations(
                    $eventReflectionProperty->getReflectionProperty()
                ), $eventReflectionProperty->getReflectionProperty()
                );
            }
        }
        $class = $annotations->getReflectionClass()->getName();
        $methods = get_class_methods($class);
        foreach($methods as $method)
        {
            $methodReflection = new ReflectionMethod($class, $method);
            $methodAnnotations = $this->getAnnotationReader()->getMethodAnnotations($methodReflection);
            $annotations->addMethodAnnotation($methodReflection->getName(),$methodAnnotations,$methodReflection);
        }

        return $annotations;
    }

    protected function getClassFormFile($file)
    {
        $contents = file_get_contents($file);
        $namespace = $class = "";
        $getting_namespace = $getting_class = false;
        foreach (token_get_all($contents) as $token)
        {
            if (is_array($token) && $token[0] == T_NAMESPACE)
            {
                $getting_namespace = true;
            }
            if (is_array($token) && $token[0] == T_CLASS)
            {
                $getting_class = true;
            }
            if ($getting_namespace === true)
            {
                if (is_array($token) && in_array($token[0], [T_STRING, T_NS_SEPARATOR]))
                {
                    $namespace .= $token[1];
                }
                else if ($token === ';')
                {
                    $getting_namespace = false;
                }
            }
            if ($getting_class === true)
            {

                if (is_array($token) && $token[0] == T_STRING)
                {
                    $class = $token[1];
                    break;
                }
            }
        }

        /** @var ReadAnnotationServiceGetClassFromFileEvent $event */
        $event =
            (new ReadAnnotationServiceGetClassFromFileEvent())->setNamespace($namespace)->setClass($class)->setSubject(
                $this
            );
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'getClassFromFile'), $event);

        return $event->getNamespace() ? $event->getNamespace() . '\\' . $event->getClass() : $event->getClass();

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

    /**
     * @return AnnotationReader
     */
    public function getAnnotationReader(): AnnotationReader
    {
        return $this->annotationReader;
    }
}
