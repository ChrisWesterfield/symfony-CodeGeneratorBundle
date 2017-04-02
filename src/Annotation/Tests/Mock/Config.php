<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class Config
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS","ANNOTATION", "PROPERTY"})
 */
final class Config extends CG\AbstractAnnotation implements CG\PropertyInterface
{
    /**
     * @var bool
     */
    public $originalConstructor = true;

    /**
     * @var bool
     */
    public $originalClone=true;

    /**
     * @var bool
     */
    public $argumentCloning=true;

    /**
     * @var bool
     */
    public $mockUnknowTypes=true;

    /**
     * @var array
     */
    public $constructorParameters;

    /**
     * @var bool
     */
    public $autoload=true;

    /**
     * @return bool
     */
    public function isOriginalConstructor(): bool
    {
        return $this->originalConstructor;
    }

    /**
     * @param bool $originalConstructor
     *
     * @return Config
     */
    public function setOriginalConstructor(bool $originalConstructor): Config
    {
        $this->originalConstructor = $originalConstructor;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOriginalClone(): bool
    {
        return $this->originalClone;
    }

    /**
     * @param bool $originalClone
     *
     * @return Config
     */
    public function setOriginalClone(bool $originalClone): Config
    {
        $this->originalClone = $originalClone;

        return $this;
    }

    /**
     * @return bool
     */
    public function isArgumentCloning(): bool
    {
        return $this->argumentCloning;
    }

    /**
     * @param bool $argumentCloning
     *
     * @return Config
     */
    public function setArgumentCloning(bool $argumentCloning): Config
    {
        $this->argumentCloning = $argumentCloning;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMockUnknowTypes(): bool
    {
        return $this->mockUnknowTypes;
    }

    /**
     * @param bool $mockUnknowTypes
     *
     * @return Config
     */
    public function setMockUnknowTypes(bool $mockUnknowTypes): Config
    {
        $this->mockUnknowTypes = $mockUnknowTypes;

        return $this;
    }

    /**
     * @return array
     */
    public function getConstructorParameters(): array
    {
        return $this->constructorParameters;
    }

    /**
     * @param array $constructorParameters
     *
     * @return Config
     */
    public function setConstructorParameters(array $constructorParameters): Config
    {
        $this->constructorParameters = $constructorParameters;

        return $this;
    }
}
