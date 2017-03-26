<?php

namespace MjrOne\CodeGenerator\PhpUnitCodeModel\Value;

use MjrOne\CodeGenerator\PhpUnitCodeModel\AbstractSimpleValue;

/**
 * HighValue
 */
class HighValue extends AbstractSimpleValue
{
    /**
     * @{inheritdoc}
     */
    public function getAsScalar()
    {
        return $this->value;
    }
}
