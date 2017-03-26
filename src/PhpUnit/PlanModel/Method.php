<?php

namespace MjrOne\CodeGenerator\PhpUnitPlanModel;

use MjrOne\CodeGenerator\PhpUnitPlanModel\Expectation;

/**
 * Method
 */
class Method
{
    /**
     * @var Expectation[]
     */
    private $expectations;
    /**
     * @var bool
     */
    private $enabled;

    /**
     * @param Expectation[]      $expectations (default)
     * @param bool          $enabled (default)
     */
    public function __construct(array $expectations = [], $enabled = true)
    {
        $this->expectations = $expectations;
        $this->enabled = $enabled;
    }

    /**
     * @param Expectation $expectation
     *
     * @return $this
     */
    public function addExpectation(Expectation $expectation)
    {
        $this->expectations[] = $expectation;

        return $this;
    }

    /**
     * @return Expectation[]
     */
    public function getExpectations()
    {
        return $this->expectations;
    }

    /**
     * @return bool
     */
    public function isEnable()
    {
        return $this->enabled;
    }
}
