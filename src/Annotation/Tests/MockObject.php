<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Tests;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock\Config;
use MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit\MockObjectGenerator;

/**
 * Class MockObject
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation\Tests
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS","ANNOTATION", "PROPERTY"})
 */
final class MockObject extends CG\AbstractAnnotation implements CG\SubDriverInterface, CG\ClassInterface, CG\PropertyInterface
{
    const DRIVER = MockObjectGenerator::class;
    /**
     * @var bool
     */
    public $ignore=false;

    /**
     * @var bool
     */
    public $abstract=false;

    /**
     * @var bool
     */
    public $trait = false;

    /**
     * @var string
     */
    public $class;

    /**
     * @var string
     */
    public $name;

    /**
     * @var \MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock\Config
     */
    public $config;

    /**
     * @var array<\MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock\Method>
     */
    public $methods;

    /**
     * @var array
     */
    public $mapping;

    /**
     * @return bool
     */
    public function isIgnore(): bool
    {
        return $this->ignore;
    }

    /**
     * @param bool $ignore
     *
     * @return MockObject
     */
    public function setIgnore(bool $ignore): MockObject
    {
        $this->ignore = $ignore;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return MockObject
     */
    public function setName(string $name): MockObject
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @param Config $config
     *
     * @return MockObject
     */
    public function setConfig(Config $config): MockObject
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return array
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     *
     * @return MockObject
     */
    public function setMethods(array $methods): MockObject
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return array
     */
    public function getMapping(): array
    {
        return $this->mapping;
    }

    /**
     * @param array $mapping
     *
     * @return MockObject
     */
    public function setMapping(array $mapping): MockObject
    {
        $this->mapping = $mapping;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAbstract(): bool
    {
        return $this->abstract;
    }

    /**
     * @param bool $abstract
     *
     * @return MockObject
     */
    public function setAbstract(bool $abstract): MockObject
    {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTrait(): bool
    {
        return $this->trait;
    }

    /**
     * @param bool $trait
     *
     * @return MockObject
     */
    public function setTrait(bool $trait): MockObject
    {
        $this->trait = $trait;

        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return MockObject
     */
    public function setClass(string $class): MockObject
    {
        $this->class = $class;

        return $this;
    }

}
