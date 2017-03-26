<?php

namespace MjrOne\CodeGenerator\PhpUnitCodeModel\Expression;

use MjrOne\CodeGenerator\PhpUnitCodeModel\Expression;
use MjrOne\CodeGenerator\PhpUnitCodeModel\Parameter;
use MjrOne\CodeGenerator\PhpUnitCodeModel\Value;

/**
 * Assign
 */
class Assign extends Expression
{
    /**
     * @var Value
     */
    private $objectValue;
    /**
     * @var Expression
     */
    private $expression;

    /**
     * @param Value         $objectValue
     * @param Expression    $expression
     */
    public function __construct(Value $objectValue, Expression $expression)
    {
        $this->objectValue = $objectValue;
        $this->expression = $expression;
    }

    /**
     * @return Expression
     */
    public function getExpression()
    {
        return $this->expression;
    }
}
