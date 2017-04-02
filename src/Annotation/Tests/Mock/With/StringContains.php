<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock\With;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class StringContains
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock\With
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS","ANNOTATION", "PROPERTY"})
 */
class StringContains
{
    /**
     * @var string
     */
    public $string;

    /**
     * @var bool
     */
    public $case=false;

    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * @param string $string
     *
     * @return StringContains
     */
    public function setString(string $string): StringContains
    {
        $this->string = $string;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCase(): bool
    {
        return $this->case;
    }

    /**
     * @param bool $case
     *
     * @return StringContains
     */
    public function setCase(bool $case): StringContains
    {
        $this->case = $case;

        return $this;
    }
}
