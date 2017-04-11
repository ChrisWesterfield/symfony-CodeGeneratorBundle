<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock\With;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class Equals
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock\With
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS","ANNOTATION", "PROPERTY"})
 */
class Equals
{
    /**
     * @var mixed
     */
    public $value;

    /**
     * @var int
     */
    public $delta=0;

    /**
     * @var int
     */
    public $maxDepth=0;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return Equals
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getDelta(): int
    {
        return $this->delta;
    }

    /**
     * @param int $delta
     *
     * @return Equals
     */
    public function setDelta(int $delta): Equals
    {
        $this->delta = $delta;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxDepth(): int
    {
        return $this->maxDepth;
    }

    /**
     * @param int $maxDepth
     *
     * @return Equals
     */
    public function setMaxDepth(int $maxDepth): Equals
    {
        $this->maxDepth = $maxDepth;

        return $this;
    }
}
