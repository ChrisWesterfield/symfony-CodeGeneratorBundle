<?php
declare(strict_types = 1);
/**
 * Created by Christopher Westerfield
 * copyright by Christopher Westerfield
 * Date: 24/12/2016
 * Time: 13:57
 */

namespace MJR\CodeGeneratorBundle\Annotation\PropertyDefinition;
use MJR\CodeGeneratorBundle\Exception\ServicesCountNotEqualsClassCountException;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;

/**
 * Class Properties
 *
 * @package CodeGeneratorBundle\Annotation\PropertyDefinition
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class Properties extends AbstractAnnotation
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
     * @var string
     */
    public $constructorMethod;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $generatedName = '';

    /**
     * @var bool
     */
    public $optional=false;

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return Properties
     */
    public function setService(string $service): Properties
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
     * @return Properties
     */
    public function setClassName(string $className): Properties
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
     * @return Properties
     */
    public function setClassShort(string $classShort): Properties
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
     * @return Properties
     */
    public function setClassAlias(string $classAlias): Properties
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
     * @return Properties
     */
    public function setIgnore(bool $ignore): Properties
    {
        $this->ignore = $ignore;
        return $this;
    }

    /**
     * @return string
     */
    public function getConstructorMethod()
    {
        return $this->constructorMethod;
    }

    /**
     * @param string $constructorMethod
     * @return Properties
     */
    public function setConstructorMethod(string $constructorMethod): Properties
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
     * @return Properties
     */
    public function setName(string $name): Properties
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
     * @return Properties
     */
    public function setGeneratedName(string $generatedName): Properties
    {
        $this->generatedName = $generatedName;
        return $this;
    }

    /**
     * @return bool
     */
    public function getOptional()
    {
        return $this->optional;
    }

    public function isOptional()
    {
        return $this->optional;
    }

    /**
     * @param bool $optional
     * @return Properties
     */
    public function setOptional(bool $optional): Properties
    {
        $this->optional = $optional;
        return $this;
    }
}
