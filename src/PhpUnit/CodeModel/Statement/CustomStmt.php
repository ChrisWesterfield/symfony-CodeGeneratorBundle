<?php

namespace MjrOne\CodeGenerator\PhpUnitCodeModel\Statement;

use MjrOne\CodeGenerator\PhpUnitCodeModel\Expression;
use MjrOne\CodeGenerator\PhpUnitCodeModel\Statement;

/**
 * CustomStmt
 */
class CustomStmt implements Statement
{
    /**
     * @var Expression
     */
    private $expression;

    /**
     * @param Expression $expression
     */
    public function __construct($expression)
    {
        $this->expression = $expression;
    }

    /**
     * @param Expression $expression
     *
     * @return $this
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;

        return $this;
    }

    /**
     * @return Expression
     */
    public function getExpression()
    {
        return $this->expression;
    }
}
