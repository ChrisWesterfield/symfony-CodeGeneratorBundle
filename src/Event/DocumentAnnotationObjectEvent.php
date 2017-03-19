<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 18/03/2017
 * Time: 01:57
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Document\Annotation;
use MjrOne\CodeGeneratorBundle\Document\Property;
use ReflectionClass;
use Symfony\Component\EventDispatcher\Event;

class DocumentAnnotationObjectEvent extends Event
{
    /**
     * @var Annotation
     */
    protected $subject;

    /**
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * @var array
     */
    protected $classAnnotations;

    /**
     * @var CG\ClassInterface
     */
    protected $annotation;

    /**
     * @var Property
     */
    protected $property;

    /**
     * @return Annotation
     */
    public function getSubject(): Annotation
    {
        return $this->subject;
    }

    /**
     * @param Annotation $subject
     *
     * @return DocumentAnnotationObjectEvent
     */
    public function setSubject(Annotation $subject): DocumentAnnotationObjectEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return \ReflectionClass
     */
    public function getReflection(): \ReflectionClass
    {
        return $this->reflection;
    }

    /**
     * @param \ReflectionClass $reflection
     *
     * @return DocumentAnnotationObjectEvent
     */
    public function setReflection(\ReflectionClass $reflection): DocumentAnnotationObjectEvent
    {
        $this->reflection = $reflection;

        return $this;
    }

    /**
     * @return array
     */
    public function getClassAnnotations(): array
    {
        return $this->classAnnotations;
    }

    /**
     * @param array $classAnnotations
     *
     * @return DocumentAnnotationObjectEvent
     */
    public function setClassAnnotations(array $classAnnotations): DocumentAnnotationObjectEvent
    {
        $this->classAnnotations = $classAnnotations;

        return $this;
    }

    /**
     * @return CG\ClassInterface
     */
    public function getAnnotation(): CG\ClassInterface
    {
        return $this->annotation;
    }

    /**
     * @param CG\ClassInterface $annotation
     *
     * @return DocumentAnnotationObjectEvent
     */
    public function setAnnotation(CG\ClassInterface $annotation = null
    ): DocumentAnnotationObjectEvent
    {
        $this->annotation = $annotation;

        return $this;
    }

    /**
     * @return Property
     */
    public function getProperty(): Property
    {
        return $this->property;
    }

    /**
     * @param Property $property
     *
     * @return DocumentAnnotationObjectEvent
     */
    public function setProperty(Property $property): DocumentAnnotationObjectEvent
    {
        $this->property = $property;

        return $this;
    }

}
