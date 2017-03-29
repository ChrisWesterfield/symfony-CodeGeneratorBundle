<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class Expect
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS","ANNOTATION", "PROPERTY"})
 */
final class Expect implements CG\PropertyInterface
{
    /**
     * @var bool
     */
    public $once=false;

    /**
     * @var bool
     */
    public $any=false;

    /**
     * @var bool
     */
    public $never=false;

    /**
     * @var bool
     */
    public $atLeastOnce=false;

    /**
     * @var int
     */
    public $exactly;

    /**
     * @var int
     */
    public $atIndex;

    /**
     * @return bool
     */
    public function isOnce(): bool
    {
        return $this->once;
    }

    /**
     * @param bool $once
     *
     * @return Expect
     */
    public function setOnce(bool $once): Expect
    {
        $this->once = $once;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAny(): bool
    {
        return $this->any;
    }

    /**
     * @param bool $any
     *
     * @return Expect
     */
    public function setAny(bool $any): Expect
    {
        $this->any = $any;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNever(): bool
    {
        return $this->never;
    }

    /**
     * @param bool $never
     *
     * @return Expect
     */
    public function setNever(bool $never): Expect
    {
        $this->never = $never;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAtLeastOnce(): bool
    {
        return $this->atLeastOnce;
    }

    /**
     * @param bool $atLeastOnce
     *
     * @return Expect
     */
    public function setAtLeastOnce(bool $atLeastOnce): Expect
    {
        $this->atLeastOnce = $atLeastOnce;

        return $this;
    }

    /**
     * @return int
     */
    public function getExactly(): int
    {
        return $this->exactly;
    }

    /**
     * @param int $exactly
     *
     * @return Expect
     */
    public function setExactly(int $exactly): Expect
    {
        $this->exactly = $exactly;

        return $this;
    }

    /**
     * @return int
     */
    public function getAtIndex(): int
    {
        return $this->atIndex;
    }

    /**
     * @param int $atIndex
     *
     * @return Expect
     */
    public function setAtIndex(int $atIndex): Expect
    {
        $this->atIndex = $atIndex;

        return $this;
    }
}
