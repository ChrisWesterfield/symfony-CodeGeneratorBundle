<?php
declare(strict_types = 1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Service;
use MjrOne\CodeGeneratorBundle\Annotation\PropertyInterface;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;

/**
 * Class Property
 *
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * @package CodeGeneratorBundle\Annotation\PropertyDefinition
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class Property extends AbstractAnnotation implements PropertyInterface
{
    /**
     * @var string
     */
    public $service;

    /**
     * @var string
     */
    public $className;

    /**
     * @var string
     */
    public $classShort;

    /**
     * @var string
     */
    public $classAlias;

    /**
     * @var bool
     */
    public $ignore=false;

    /**
     * @var array<\MjrOne\CodeGeneratorBundle\Annotation\Service\Construction>
     */
    public $constructorMethod=null;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $generatedName = '';

    /**
     * @var \MjrOne\CodeGeneratorBundle\Annotation\Service\Optional
     */
    public $optional=null;

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return Property
     */
    public function setService(string $service): Property
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     * @return Property
     */
    public function setClassName(string $className): Property
    {
        $this->className = $className;
        return $this;
    }

    /**
     * @return string
     */
    public function getClassShort()
    {
        return $this->classShort;
    }

    /**
     * @param string $classShort
     * @return Property
     */
    public function setClassShort(string $classShort): Property
    {
        $this->classShort = $classShort;
        return $this;
    }

    /**
     * @return string
     */
    public function getClassAlias()
    {
        return $this->classAlias;
    }

    /**
     * @param string $classAlias
     * @return Property
     */
    public function setClassAlias(string $classAlias): Property
    {
        $this->classAlias = $classAlias;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIgnore()
    {
        return $this->ignore;
    }

    public function isIgnore()
    {
        return $this->ignore;
    }

    /**
     * @param bool $ignore
     * @return Property
     */
    public function setIgnore(bool $ignore): Property
    {
        $this->ignore = $ignore;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getConstructorMethod()
    {
        return $this->constructorMethod;
    }

    /**
     * @param array $constructorMethod
     * @return Property
     */
    public function setConstructorMethod(array $constructorMethod): Property
    {
        $this->constructorMethod = $constructorMethod;
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
     * @return Property
     */
    public function setName(string $name): Property
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getGeneratedName()
    {
        return $this->generatedName;
    }

    /**
     * @param string $generatedName
     * @return Property
     */
    public function setGeneratedName(string $generatedName): Property
    {
        $this->generatedName = $generatedName;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getOptional()
    {
        return $this->optional;
    }

    /**
     * @param array $optional
     *
     * @return Property
     */
    public function setOptional(array $optional): Property
    {
        $this->optional = $optional;

        return $this;
    }
}
