<?php

namespace MjrOne\CodeGenerator\PhpUnitCodeModel;

/**
 * AbstractSimpleValue
 */
abstract class AbstractSimpleValue extends AbstractValue
{
    /**
     * @return mixed
     */
    abstract public function getAsScalar();
}
