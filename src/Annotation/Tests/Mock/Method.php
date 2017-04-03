<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class Method
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS","ANNOTATION", "PROPERTY"})
 */
final class Method extends CG\AbstractAnnotation implements CG\PropertyInterface
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var bool
     */
    public $ignore=false;

    /**
     * @var \MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock\Will
     */
    public $will;

    /**
     * @var array<\MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock\With>
     */
    public $with;

    /**
     * @var array
     */
    public $mapping;

    /**
     * @var \MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock\Expect
     */
    public $expects;

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
     * @return Method
     */
    public function setName(string $name): Method
    {
        $this->name = $name;

        return $this;
    }

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
     * @return Method
     */
    public function setIgnore(bool $ignore): Method
    {
        $this->ignore = $ignore;

        return $this;
    }

    /**
     * @return Will
     */
    public function getWill(): Will
    {
        return $this->will;
    }

    /**
     * @param Will $will
     *
     * @return Method
     */
    public function setWill(Will $will): Method
    {
        $this->will = $will;

        return $this;
    }

    /**
     * @return array
     */
    public function getWith(): array
    {
        return $this->with;
    }

    /**
     * @param array $with
     *
     * @return Method
     */
    public function setWith(array $with): Method
    {
        $this->with = $with;

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
     * @return Method
     */
    public function setMapping(array $mapping): Method
    {
        $this->mapping = $mapping;

        return $this;
    }

    /**
     * @return Expect
     */
    public function getExpects(): Expect
    {
        return $this->expects;
    }

    /**
     * @param Expect $expects
     *
     * @return Method
     */
    public function setExpects(Expect $expects): Method
    {
        $this->expects = $expects;

        return $this;
    }
}
