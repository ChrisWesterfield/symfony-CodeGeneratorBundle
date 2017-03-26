<?php

namespace MjrOne\CodeGenerator\PhpUnitCodeModel\Value;

use MjrOne\CodeGenerator\PhpUnitCodeModel\AbstractSimpleValue;

/**
 * VariableNameValue
 */
class VariableNameValue extends AbstractSimpleValue
{
    /**
     * @{inheritdoc}
     */
    public function getAsScalar()
    {
        return sprintf('$%s', $this->value);
    }
}
