<?php

namespace MjrOne\CodeGenerator\PhpUnitCodeModel;

/**
 * AbstractValue
 */
abstract class AbstractValue implements Value
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue()
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
