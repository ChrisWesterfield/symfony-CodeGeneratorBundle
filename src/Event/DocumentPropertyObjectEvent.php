<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Document\Property;
use ReflectionProperty;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class DocumentPropertyObjectEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class DocumentPropertyObjectEvent extends Event
{
    /**
     * @var Property
     */
    protected $subject;

    /**
     * @var array
     */
    protected $annotations;

    /**
     * @var ReflectionProperty
     */
    protected $property;

    /**
     * @var CG\PropertyInterface
     */
    protected $annotation;

    /**
     * @return Property
     */
    public function getSubject(): Property
    {
        return $this->subject;
    }

    /**
     * @param Property $subject
     *
     * @return DocumentPropertyObjectEvent
     */
    public function setSubject(Property $subject): DocumentPropertyObjectEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return array
     */
    public function getAnnotations(): array
    {
        return $this->annotations;
    }

    /**
     * @param array $annotations
     *
     * @return DocumentPropertyObjectEvent
     */
    public function setAnnotations(array $annotations): DocumentPropertyObjectEvent
    {
        $this->annotations = $annotations;

        return $this;
    }

    /**
     * @return \ReflectionProperty
     */
    public function getProperty(): \ReflectionProperty
    {
        return $this->property;
    }

    /**
     * @param \ReflectionProperty $property
     *
     * @return DocumentPropertyObjectEvent
     */
    public function setProperty(\ReflectionProperty $property): DocumentPropertyObjectEvent
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return CG\PropertyInterface
     */
    public function getAnnotation(): CG\PropertyInterface
    {
        return $this->annotation;
    }

    /**
     * @param CG\PropertyInterface $annotation
     *
     * @return DocumentPropertyObjectEvent
     */
    public function setAnnotation(CG\PropertyInterface $annotation = null
    ): DocumentPropertyObjectEvent
    {
        $this->annotation = $annotation;

        return $this;
    }
}
