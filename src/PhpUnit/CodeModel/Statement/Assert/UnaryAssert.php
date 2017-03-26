<?php

namespace MjrOne\CodeGenerator\PhpUnitCodeModel\Statement\Assert;

use MjrOne\CodeGenerator\PhpUnitCodeModel\Statement\AbstractAssert;
use MjrOne\CodeGenerator\PhpUnitCodeModel\Value;

/**
 * UnaryAssert
 *
 * @method string isTrue()
 *
 *
 * @method string makeTrue()
 */
class UnaryAssert extends AbstractAssert
{
    /**
     * @var Value
     */
    private $operand;

    /**
     * @param Value    $operand
     * @param string            $operation
     */
    public function __construct(Value $operand, $operation)
    {
        parent::__construct($operation);

        $this->operand =  $operand;
    }

    /**
     * @param Value $operand
     *
     * @return $this
     */
    public function setOperand(Value $operand)
    {
        $this->operand = $operand;

        return $this;
    }

    /**
     * @return Value
     */
    public function getOperand()
    {
        return $this->operand;
    }

    /**
     * {@inheritdoc}
     */
    protected function supportsOperation($operation)
    {
        return in_array($operation, ['true']);
    }
}
