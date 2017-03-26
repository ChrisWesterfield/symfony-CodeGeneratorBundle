<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\DocumentPropertyObjectEvent;
use MjrOne\CodeGeneratorBundle\Services\EventDispatcherService;
use ReflectionProperty;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\Type;

/**
 * Class Property
 *
 * @package   MjrOne\CodeGeneratorBundle\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Property
{
    /**
     * @var string
     */
    protected $field;
    /**
     * @var ReflectionProperty
     */
    protected $reflection;
    /**
     * @var ArrayCollection
     */
    protected $annotations;
    /**
     * @var ArrayCollection
     */
    protected $rawAnnotations;

    /**
     * @var Type
     */
    protected $type;

    /**
     * @var PropertyInfoExtractor
     */
    protected $extractor;
    /**
     * @var bool
     */
    protected $readable;
    /**
     * @var bool
     */
    protected $writable;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var ArrayCollection
     */
    protected $properties;

    /**
     * @var EventDispatcherService
     */
    protected $eventDispatcher;

    /**
     * Property constructor.
     */
    public function __construct(EventDispatcherService $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        $phpDocExtractor = new PhpDocExtractor();
        $reflectionExtractor = new ReflectionExtractor();
        $listExtractor = [$reflectionExtractor];
        $typeExtractor = [$phpDocExtractor, $reflectionExtractor];
        $descriptionExtractor = [$phpDocExtractor];
        $accessExtractor = [$reflectionExtractor];
        $this->extractor = new PropertyInfoExtractor(
            $listExtractor,
            $typeExtractor,
            $descriptionExtractor,
            $accessExtractor
        );
        $event = (new DocumentPropertyObjectEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'constructor'), $event);
    }

    /**
     *
     */
    public function __clone()
    {
        $this->reflection = null;
        $this->annotations = new ArrayCollection();
        $this->rawAnnotations = new ArrayCollection();
        $this->properties = null;
        $this->type = null;
        $event = (new DocumentPropertyObjectEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'clone'), $event);
    }

    /**
     * @param                     $field
     * @param array               $annotations
     * @param \ReflectionProperty $property
     *
     * @return \MjrOne\CodeGeneratorBundle\Document\Property
     */
    public function readAnnotaiton($field, array $annotations, ReflectionProperty $property): Property
    {
        $event = (new DocumentPropertyObjectEvent())->setSubject($this)->setAnnotations($annotations)->setProperty(
            $property
        );
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'readAnnotation.prepare'), $event);

        if ($field instanceof ReflectionProperty)
        {
            $fieldName = $field->getName();
        }
        else
        {
            $fieldName = $field;
        }
        $this->field = $fieldName;
        $this->rawAnnotations = new ArrayCollection($annotations);
        if ($this->rawAnnotations->count() > 0)
        {
            foreach ($this->rawAnnotations as $annotation)
            {
                if ($annotation instanceof CG\PropertyInterface)
                {
                    $event->setAnnotation($annotation);
                    $this->getED()->dispatch($this->getED()->getEventName(self::class, 'readAnnotation.add'), $event);
                    $this->annotations->add($annotation);
                }
            }
        }
        $event->setAnnotation(null);
        $this->reflection = $property;
        $type = $this->extractor->getTypes($property->getDeclaringClass()->getName(), $fieldName);
        if ((array)$type === $type)
        {
            $this->type = reset($type);
        }
        $this->readable = $this->extractor->isReadable($property->getDeclaringClass()->getName(), $fieldName);
        $this->writable = $this->extractor->isWritable($property->getDeclaringClass()->getName(), $fieldName);
        $this->description =
            $this->extractor->getLongDescription($property->getDeclaringClass()->getName(), $fieldName);
        $this->properties =
            new ArrayCollection($this->extractor->getProperties($property->getDeclaringClass()->getName()));
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'readAnnotation.post'), $event);

        return $this;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return \ReflectionProperty
     */
    public function getReflection(): \ReflectionProperty
    {
        return $this->reflection;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnnotations(): ArrayCollection
    {
        return $this->annotations;
    }

    /**
     * @return ArrayCollection
     */
    public function getRawAnnotations(): ArrayCollection
    {
        return $this->rawAnnotations;
    }

    /**
     * @return \Symfony\Component\PropertyInfo\Type|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return PropertyInfoExtractor
     */
    public function getExtractor(): PropertyInfoExtractor
    {
        return $this->extractor;
    }

    /**
     * @return bool
     */
    public function isReadable(): bool
    {
        return $this->readable;
    }

    /**
     * @return bool
     */
    public function isWritable(): bool
    {
        return $this->writable;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return ArrayCollection
     */
    public function getProperties(): ArrayCollection
    {
        return $this->properties;
    }

    /**
     * @return EventDispatcherService
     */
    public function getEventDispatcher(): EventDispatcherService
    {
        return $this->eventDispatcher;
    }

    /**
     * @param EventDispatcherService $eventDispatcher
     *
     * @return Property
     */
    public function setEventDispatcher(EventDispatcherService $eventDispatcher
    ): Property
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    public function getED()
    {
        return $this->getEventDispatcher();
    }
}
