<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class With
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS","ANNOTATION", "PROPERTY"})
 */
class With extends CG\AbstractAnnotation implements CG\PropertyInterface
{
    /**
     * @var mixed
     */
    public $equals;

    /**
     * @var float
     */
    public $greater;

    /**
     * @var float
     */
    public $greaterEquals;

    /**
     * @var float
     */
    public $less;

    /**
     * @var float
     */
    public $lessEquals;

    /**
     * @var mixed
     */
    public $contains;

    /**
     * @var string
     */
    public $classHasAttribute;

    /**
     * @var \MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock\With\StringContains
     */
    public $equalsTo;

    /**
     * @var string
     */
    public $arrayHasKey;

    /**
     * @var string
     */
    public $instanceOf;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $matchRegularExpression;

    /**
     * @var \MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock\With\StringContains
     */
    public $stringContains;

    /**
     * @var bool
     */
    public $anything=false;

    /**
     * @return bool
     */
    public function isAnything(): bool
    {
        return $this->anything;
    }

    /**
     * @param bool $anything
     *
     * @return With
     */
    public function setAnything(bool $anything): With
    {
        $this->anything = $anything;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEquals()
    {
        return $this->equals;
    }

    /**
     * @param mixed $equals
     *
     * @return With
     */
    public function setEquals($equals)
    {
        $this->equals = $equals;

        return $this;
    }

    /**
     * @return float
     */
    public function getGreater()
    {
        return $this->greater;
    }

    /**
     * @param float $greater
     *
     * @return With
     */
    public function setGreater(float $greater): With
    {
        $this->greater = $greater;

        return $this;
    }

    /**
     * @return float
     */
    public function getGreaterEquals()
    {
        return $this->greaterEquals;
    }

    /**
     * @param float $greaterEquals
     *
     * @return With
     */
    public function setGreaterEquals(float $greaterEquals): With
    {
        $this->greaterEquals = $greaterEquals;

        return $this;
    }

    /**
     * @return float
     */
    public function getLess()
    {
        return $this->less;
    }

    /**
     * @param float $less
     *
     * @return With
     */
    public function setLess(float $less): With
    {
        $this->less = $less;

        return $this;
    }

    /**
     * @return float
     */
    public function getLessEquals()
    {
        return $this->lessEquals;
    }

    /**
     * @param float $lessEquals
     *
     * @return With
     */
    public function setLessEquals(float $lessEquals): With
    {
        $this->lessEquals = $lessEquals;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContains()
    {
        return $this->contains;
    }

    /**
     * @param mixed $contains
     *
     * @return With
     */
    public function setContains($contains)
    {
        $this->contains = $contains;

        return $this;
    }

    /**
     * @return string
     */
    public function getClassHasAttribute()
    {
        return $this->classHasAttribute;
    }

    /**
     * @param string $classHasAttribute
     *
     * @return With
     */
    public function setClassHasAttribute(string $classHasAttribute): With
    {
        $this->classHasAttribute = $classHasAttribute;

        return $this;
    }

    /**
     * @return With\StringContains
     */
    public function getEqualsTo(): With\StringContains
    {
        return $this->equalsTo;
    }

    /**
     * @param With\StringContains $equalsTo
     *
     * @return With
     */
    public function setEqualsTo(With\StringContains $equalsTo): With
    {
        $this->equalsTo = $equalsTo;

        return $this;
    }

    /**
     * @return string
     */
    public function getArrayHasKey()
    {
        return $this->arrayHasKey;
    }

    /**
     * @param string $arrayHasKey
     *
     * @return With
     */
    public function setArrayHasKey(string $arrayHasKey): With
    {
        $this->arrayHasKey = $arrayHasKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstanceOf()
    {
        return $this->instanceOf;
    }

    /**
     * @param string $instanceOf
     *
     * @return With
     */
    public function setInstanceOf(string $instanceOf): With
    {
        $this->instanceOf = $instanceOf;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return With
     */
    public function setType(string $type): With
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getMatchRegularExpression()
    {
        return $this->matchRegularExpression;
    }

    /**
     * @param string $matchRegularExpression
     *
     * @return With
     */
    public function setMatchRegularExpression(string $matchRegularExpression): With
    {
        $this->matchRegularExpression = $matchRegularExpression;

        return $this;
    }

    /**
     * @return With\StringContains
     */
    public function getStringContains()
    {
        return $this->stringContains;
    }

    /**
     * @param With\StringContains $stringContains
     *
     * @return With
     */
    public function setStringContains(
        With\StringContains $stringContains
    ): With
    {
        $this->stringContains = $stringContains;

        return $this;
    }
}
