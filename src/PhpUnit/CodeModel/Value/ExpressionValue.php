<?php

namespace MjrOne\CodeGenerator\PhpUnitCodeModel\Value;

use MjrOne\CodeGenerator\PhpUnitCodeModel\AbstractValue;
use MjrOne\CodeGenerator\PhpUnitCodeModel\Expression;

/**
 * ExpressionValue
 */
class ExpressionValue extends AbstractValue
{
    /**
     * @param Expression $expression
     */
    public function __construct(Expression $expression)
    {
        parent::__construct($expression);
    }
}
