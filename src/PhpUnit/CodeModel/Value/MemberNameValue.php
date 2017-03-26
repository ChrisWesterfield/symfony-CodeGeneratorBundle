<?php

namespace MjrOne\CodeGenerator\PhpUnitCodeModel\Value;

use MjrOne\CodeGenerator\PhpUnitCodeModel\AbstractSimpleValue;

/**
 * MemberNameValue
 */
class MemberNameValue extends AbstractSimpleValue
{
    /**
     * @{inheritdoc}
     */
    public function getAsScalar()
    {
        return sprintf('$this->%s', $this->value);
    }
}
