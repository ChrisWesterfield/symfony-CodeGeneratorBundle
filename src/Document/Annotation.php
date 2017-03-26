<?php
declare(strict_types = 1);


namespace MjrOne\CodeGeneratorBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\DocumentAnnotationObjectEvent;
use MjrOne\CodeGeneratorBundle\Services\EventDispatcherService;
use ReflectionProperty;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class Annotation
 *
 * @package MjrOne\CodeGeneratorBundle\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Annotation
{
    const TRAIT_NAMESPACE = 'Traits\\CodeGenerator\\';
    /**
     * @var ArrayCollection
     */
    protected $classes;
    /**
     * @var ArrayCollection
     */
    protected $properties;
    /**
     * @var string
     */
    protected $namespace;
    /**
     * @var string
     */
    protected $classShort;
    /**
     * @var string
     */
    protected $fqdnName;
    /**
     * @var \ReflectionClass
     */
    protected $reflectionClass;

    /**
     * @var ArrayCollection
     */
    protected $rawClassAnnotations;

    /**
     * @var Property
     */
    protected $propertyAnnotationPrototype;

    /**
     * @var string
     */
    protected $bundleRootNamespace;

    /**
     * @var string
     */
    protected $classNamespacePath;

    /**
     * @var EventDispatcherService
     */
    protected $eventDispatcher;

    /**
     * Annotation constructor.
     */
    public function __construct(EventDispatcherService $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->classes = new ArrayCollection();
        $this->properties = new ArrayCollection();
        $this->propertyAnnotationPrototype = new Property($eventDispatcher);
        $event = (new DocumentAnnotationObjectEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'constructor'),$event);
    }

    /**
     *
     */
    public function __clone()
    {
        $this->reflectionClass = null;
        $this->classes = new ArrayCollection();
        $this->properties = new ArrayCollection();
        $this->raw = null;
        $event = (new DocumentAnnotationObjectEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'clone'),$event);
    }

    /**
     * @return ArrayCollection
     */
    public function getClasses(): ArrayCollection
    {
        return $this->classes;
    }

    /**
     * @return ArrayCollection
     */
    public function getProperties(): ArrayCollection
    {
        return $this->properties;
    }

    /**
     * @return \ReflectionClass
     */
    public function getReflectionClass(): \ReflectionClass
    {
        return $this->reflectionClass;
    }

    /**
     * @param object $raw
     *
     * @return Annotation
     */
    public function setRaw(object $raw): Annotation
    {
        $this->raw = $raw;

        return $this;
    }

    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return Annotation
     */
    public function setReflectionClass(\ReflectionClass $reflectionClass): Annotation
    {
        $this->reflectionClass = $reflectionClass;
        $this->namespace = $reflectionClass->getNamespaceName();
        $this->classShort = $reflectionClass->getShortName();
        $this->fqdnName = $reflectionClass->getName();
        $ns = explode('\\',$this->namespace);
        $bundleRoot = [];
        foreach($ns as $n)
        {
            if(strpos($n,'Bundle')===false)
            {
                $bundleRoot[] = $n;
            }
            else
            {
                $bundleRoot[] = $n;
                break(1);
            }
        }
        $this->bundleRootNamespace = implode('\\',$bundleRoot);
        $this->classNamespacePath = trim(str_replace([$this->bundleRootNamespace,$this->classShort],'',$this->fqdnName),'\\');
        $event = (new DocumentAnnotationObjectEvent())->setSubject($this)->setReflection($reflectionClass);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'setReflectionClass'),$event);
        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getClassShort(): string
    {
        return $this->classShort;
    }

    /**
     * @return string
     */
    public function getFqdnName(): string
    {
        return $this->fqdnName;
    }

    /**
     * @return ArrayCollection
     */
    public function getRawClassAnnotations(): ArrayCollection
    {
        return $this->rawClassAnnotations;
    }

    /**
     * @param array $classAnnotations
     *
     * @return Annotation
     */
    public function setRawClassAnnotations(array $classAnnotations): Annotation
    {
        $this->rawClassAnnotations = new ArrayCollection((array)$classAnnotations);
        $event = (new DocumentAnnotationObjectEvent())->setSubject($this);
        if(count($classAnnotations) > 0)
        {
            foreach($classAnnotations as $annotation)
            {
                if($annotation instanceof CG\ClassInterface)
                {
                    $event->setAnnotation($annotation);
                    $this->getED()->dispatch($this->getED()->getEventName(self::class,'setRawClassAnnotation.perAnnotation'),$event);
                    $this->classes->add($event->getAnnotation());
                }
            }
        }
        $event->setClassAnnotations($classAnnotations)->setAnnotation(null);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'setRawClassAnnotation'),$event);
        return $this;
    }

    /**
     * @param                     $field
     * @param array               $annotations
     * @param \ReflectionProperty $reflectionProperty
     *
     * @return Annotation
     */
    public function addPropertyAnnotation($field, array $annotations, ReflectionProperty $reflectionProperty): Annotation
    {
        $property = clone $this->propertyAnnotationPrototype;
        $property->setEventDispatcher($this->getED());
        $property->readAnnotaiton($field, $annotations, $reflectionProperty);
        $event = (new DocumentAnnotationObjectEvent())->setSubject($this)->setProperty($property);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'addPropertyAnnotation'),$event);
        $this->properties->set($field, $property);
        return $this;
    }

    /**
     * @return Property
     */
    public function getPropertyAnnotationPrototype(): Property
    {
        return $this->propertyAnnotationPrototype;
    }

    /**
     * @return string
     */
    public function getBundleRootNamespace(): string
    {
        return $this->bundleRootNamespace;
    }

    /**
     * @return string
     */
    public function getClassNamespacePath(): string
    {
        return $this->classNamespacePath;
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
        return $this->eventDispatcher;
    }
}
