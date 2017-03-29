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
class With implements CG\PropertyInterface
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
    public $lower;

    /**
     * @var float
     */
    public $lowerEquals;

    /**
     * @var mixed
     */
    public $notEquals;

    /**
     * @var string
     */
    public $stringContains;

    /**
     * @var bool
     */
    public $anything=false;

    /**
     * @var string
     */
    public $callBack;

    /**
     * @var array
     */
    public $consecutiveCalls;

    /**
     * @return mixed
     */
    public function getEquals()
    {
        return $this->equals;
    }

    /**
     * @param mixed $equals
     */
    public function setEquals($equals)
    {
        $this->equals = $equals;
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
     */
    public function setGreater(float $greater)
    {
        $this->greater = $greater;
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
     */
    public function setGreaterEquals(float $greaterEquals)
    {
        $this->greaterEquals = $greaterEquals;
    }

    /**
     * @return float
     */
    public function getLower()
    {
        return $this->lower;
    }

    /**
     * @param float $lower
     */
    public function setLower(float $lower)
    {
        $this->lower = $lower;
    }

    /**
     * @return float
     */
    public function getLowerEquals()
    {
        return $this->lowerEquals;
    }

    /**
     * @param float $lowerEquals
     */
    public function setLowerEquals(float $lowerEquals)
    {
        $this->lowerEquals = $lowerEquals;
    }

    /**
     * @return mixed
     */
    public function getNotEquals()
    {
        return $this->notEquals;
    }

    /**
     * @param mixed $notEquals
     */
    public function setNotEquals($notEquals)
    {
        $this->notEquals = $notEquals;
    }

    /**
     * @return string
     */
    public function getStringContains()
    {
        return $this->stringContains;
    }

    /**
     * @param string $stringContains
     */
    public function setStringContains(string $stringContains)
    {
        $this->stringContains = $stringContains;
    }

    /**
     * @return bool
     */
    public function isAnything(): bool
    {
        return $this->anything;
    }

    /**
     * @param bool $anything
     */
    public function setAnything(bool $anything)
    {
        $this->anything = $anything;
    }

    /**
     * @return string
     */
    public function getCallBack()
    {
        return $this->callBack;
    }

    /**
     * @param string $callBack
     */
    public function setCallBack(string $callBack)
    {
        $this->callBack = $callBack;
    }

    /**
     * @return array
     */
    public function getConsecutiveCalls()
    {
        return $this->consecutiveCalls;
    }

    /**
     * @param array $consecutiveCalls
     */
    public function setConsecutiveCalls(array $consecutiveCalls)
    {
        $this->consecutiveCalls = $consecutiveCalls;
    }
}
