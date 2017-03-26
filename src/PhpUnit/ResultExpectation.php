<?php

namespace MjrOne\CodeGenerator\PhpUnitPlanModel;

use MjrOne\CodeGenerator\PhpUnitPlanModel\AbstractExpectation;
use MjrOne\CodeGenerator\PhpUnitPlanModel\Path;
use MjrOne\CodeGenerator\PhpUnitPlanModel\Value;

/**
 * ResultExpectation
 */
class ResultExpectation extends AbstractExpectation
{
    /**
     * @var Value
     */
    private $result;
    /**
     * @var Path
     */
    private $path;

    /**
     * @param Value $result
     * @param Path  $path
     * @param bool  $enabled (default)
     */
    public function __construct(Value $result, Path $path, $enabled = true)
    {
        parent::__construct($enabled);

        $this->expectation = $result;
        $this->path = $path;
    }

    /**
     * @return Value
     */
    public function getResult()
    {
        return $this->expectation;
    }

    /**
     * @return Path
     */
    public function getPath()
    {
        return $this->path;
    }
}
