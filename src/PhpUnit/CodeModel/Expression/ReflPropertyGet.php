<?php

namespace MjrOne\CodeGenerator\PhpUnitCodeModel\Expression;

use MjrOne\CodeGenerator\PhpUnitCodeModel\Expression;
use MjrOne\CodeGenerator\PhpUnitCodeModel\Value;

/**
 * ReflPropertyGet
 */
class ReflPropertyGet implements Expression
{
    /**
     * @var Value
     */
    private $objectValue;
    /**
     * @var string
     */
    private $propertyName;

    /**
     * @param Value    $objectValue
     * @param string            $propertyName
     */
    public function __construct(Value $objectValue, $propertyName)
    {
        $this->objectValue = $objectValue;
        $this->propertyName = $propertyName;
    }

    /**
     * @return Value
     */
    public function getObjectValue()
    {
        return $this->objectValue;
    }

    /**
     * @return string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }
}
