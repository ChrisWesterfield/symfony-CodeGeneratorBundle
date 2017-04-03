<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class Will
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation\Tests\Mock
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS","ANNOTATION", "PROPERTY"})
 */
final class Will extends CG\AbstractAnnotation implements CG\PropertyInterface
{
    /**
     * @var mixed
     */
    public $value;
    /**
     * @var bool
     */
    public $self=false;
    /**
     * @var int
     */
    public $argument;
    /**
     * @var string
     */
    public $mapName;

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
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return Will
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSelf(): bool
    {
        return $this->self;
    }

    /**
     * @param bool $self
     *
     * @return Will
     */
    public function setSelf(bool $self): Will
    {
        $this->self = $self;

        return $this;
    }

    /**
     * @return int
     */
    public function getArgument(): int
    {
        return $this->argument;
    }

    /**
     * @param int $argument
     *
     * @return Will
     */
    public function setArgument(int $argument): Will
    {
        $this->argument = $argument;

        return $this;
    }

    /**
     * @return string
     */
    public function getMapName(): string
    {
        return $this->mapName;
    }

    /**
     * @param string $mapName
     *
     * @return Will
     */
    public function setMapName(string $mapName): Will
    {
        $this->mapName = $mapName;

        return $this;
    }

    /**
     * @return string
     */
    public function getCallBack(): string
    {
        return $this->callBack;
    }

    /**
     * @param string $callBack
     *
     * @return Will
     */
    public function setCallBack(string $callBack): Will
    {
        $this->callBack = $callBack;

        return $this;
    }

    /**
     * @return array
     */
    public function getConsecutiveCalls(): array
    {
        return $this->consecutiveCalls;
    }

    /**
     * @param array $consecutiveCalls
     *
     * @return Will
     */
    public function setConsecutiveCalls(array $consecutiveCalls): Will
    {
        $this->consecutiveCalls = $consecutiveCalls;

        return $this;
    }
}
