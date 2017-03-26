<?php

namespace MjrOne\CodeGenerator\PhpUnitCodeModel\Value;

use MjrOne\CodeGenerator\PhpUnitCodeModel\AbstractSimpleValue;

/**
 * ThisValue
 */
class ThisValue extends AbstractSimpleValue
{
    /**
     * @{inheritdoc}
     */
    public function getAsScalar()
    {
        return '$this';
    }
}
