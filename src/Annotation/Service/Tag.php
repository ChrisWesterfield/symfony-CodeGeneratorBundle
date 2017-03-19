<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation\Service;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;
use MjrOne\CodeGeneratorBundle\Annotation\ClassInterface;
use MjrOne\CodeGeneratorBundle\Annotation\SubDriverInterface;
use MjrOne\CodeGeneratorBundle\Services\Driver\Service\ServiceTagGenerator as TagDriver;

/**
 * Class Tag
 * @package CodeGeneratorBundle\Annotation\Service
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @package codegenerator\Annotation
 * @Annotation
 * @Target({"CLASS"})
 */
final class Tag extends AbstractAnnotation implements ClassInterface, ServiceInterface, SubDriverInterface
{
    const DRIVER = TagDriver::class;
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $event;

    /**
     * @var string
     */
    public $method;

    /**
     * @var string
     */
    public $priority;

    /**
     * @var string
     */
    public $channel;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $template;

    /**
     * @var string
     */
    public $extendedType;

    /**
     * @return string
     */
    public function getExtendedType()
    {
        return $this->extendedType;
    }

    /**
     * @param string $extendedType
     *
     * @return Tag
     */
    public function setExtendedType(string $extendedType)
    {
        $this->extendedType = $extendedType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     *
     * @return Tag
     */
    public function setTemplate(string $template): Tag
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Tag
     */
    public function setId(string $id): Tag
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     *
     * @return Tag
     */
    public function setChannel(string $channel): Tag
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Tag
     */
    public function setName(string $name): Tag
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     *
     * @return Tag
     */
    public function setAlias(string $alias): Tag
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param string $event
     *
     * @return Tag
     */
    public function setEvent(string $event): Tag
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return Tag
     */
    public function setMethod(string $method): Tag
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     *
     * @return Tag
     */
    public function setPriority(string $priority): Tag
    {
        $this->priority = $priority;

        return $this;
    }
}
