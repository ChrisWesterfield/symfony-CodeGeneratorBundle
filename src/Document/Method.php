<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Services\EventDispatcherService;
use ReflectionMethod;

/**
 * Class Method
 * @package MjrOne\CodeGeneratorBundle\Document
 * @author Christopher Westerfield <chris.westerfield@spectware.com>
 * @link https://www.spectware.com
 * @copyright Spectware, Inc.
 * @license SpectwarePro Source License
 */
class Method
{

    /**
     * @var EventDispatcherService
     */
    protected $eventDispatcher;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Annotation
     */
    protected $class;

    /**
     * @var ArrayCollection
     */
    protected $annotations;

    /**
     * @var ReflectionMethod
     */
    protected $methodReflection;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Method
     */
    public function setName(string $name): Method
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Annotation
     */
    public function getClass(): Annotation
    {
        return $this->class;
    }

    /**
     * @param Annotation $class
     * @return Method
     */
    public function setClass(Annotation $class): Method
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnnotations(): ArrayCollection
    {
        return $this->annotations;
    }

    /**
     * @param ArrayCollection $annotations
     * @return Method
     */
    public function setAnnotations(ArrayCollection $annotations): Method
    {
        $this->annotations = $annotations;
        return $this;
    }

    /**
     * Property constructor.
     */
    public function __construct(EventDispatcherService $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return EventDispatcherService
     */
    public function getEventDispatcher(): EventDispatcherService
    {
        return $this->eventDispatcher;
    }

    /**
     * @return EventDispatcherService
     */
    public function getED():EventDispatcherService
    {
        return $this->getEventDispatcher();
    }

    /**
     * @param EventDispatcherService $eventDispatcher
     * @return Method
     */
    public function setEventDispatcher(EventDispatcherService $eventDispatcher): Method
    {
        $this->eventDispatcher = $eventDispatcher;
        return $this;
    }

    /**
     * @param string $methodName
     * @param array $methodAnnotations
     * @param ReflectionMethod $methodReflection
     *
     * @return Method
     */
    public function readAnnotation(string $methodName, array $methodAnnotations, ReflectionMethod $methodReflection):Method
    {
        $this->name = $methodName;
        $this->annotations = new ArrayCollection();
        foreach($methodAnnotations as $methodAnnotation)
        {
            $this->annotations->set(get_class($methodAnnotation),$methodAnnotation);
        }
        $this->annotations = new ArrayCollection($methodAnnotations);
        $this->methodReflection = $methodReflection;
        return $this;
    }

    /**
     * @return ReflectionMethod
     */
    public function getMethodReflection(): ReflectionMethod
    {
        return $this->methodReflection;
    }

    /**
     * @param ReflectionMethod $methodReflection
     * @return Method
     */
    public function setMethodReflection(ReflectionMethod $methodReflection): Method
    {
        $this->methodReflection = $methodReflection;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPublic():bool
    {
        return $this->methodReflection->isPublic();
    }

    /**
     * @return bool
     */
    public function isProtected():bool
    {
        return $this->methodReflection->isProtected();
    }

    /**
     * @return bool
     */
    public function isPrivate():bool
    {
        return $this->methodReflection->isPrivate();
    }

    /**
     * @return bool
     */
    public function isAbstract():bool
    {
        return $this->methodReflection->isAbstract();
    }

    /**
     * @return bool
     */
    public function isStatic():bool
    {
        return $this->methodReflection->isStatic();
    }

    /**
     * @return bool
     */
    public function isConstructor():bool
    {
        return $this->methodReflection->isConstructor();
    }

    /**
     * @return bool
     */
    public function isDestructor():bool
    {
        return $this->methodReflection->isDestructor();
    }

    /**
     * @return bool
     */
    public function isFinal():bool
    {
        return $this->methodReflection->isFinal();
    }

    /**
     * @param $class
     * @return bool|object|null
     */
    public function getAnnotation($class)
    {
        if($this->annotations->containsKey($class))
        {
            return $this->annotations->get($class);
        }
        return false;
    }
}