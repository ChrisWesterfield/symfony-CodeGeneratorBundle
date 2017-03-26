<?php

namespace MjrOne\CodeGenerator\PhpUnitCodeModel;

use MjrOne\CodeGenerator\PhpUnitCodeModel\Class_;
use MjrOne\CodeGenerator\PhpUnitCodeModel\Statement\Assert_;
use MjrOne\CodeGenerator\PhpUnitCodeModel\InitStatementAwareTrait;
use MjrOne\CodeGenerator\PhpUnitCodeModel\Statement\CustomStmt;
use MjrOne\CodeGenerator\PhpUnitCodeModel\Statement\Spy;

/**
 * Method
 */
class Method
{
    use InitStatementAwareTrait;

    /**
     * @var string
     */
    private $name;
    /**
     * @var Class_
     */
    private $class;
    /**
     * @var Spy[]
     */
    private $spies = [];
    /**
     * @var CustomStmt[]
     */
    private $customStmts = [];
    /**
     * @var AbstractAssert[]
     */
    private $asserts = [];

    /**
     * @param string    $name
     * @param Class_ $class
     */
    public function __construct($name, Class_ $class)
    {
        $this->name = $name;
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Class_
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param Spy
     *
     * @return $this
     */
    public function addSpy(Spy $spy)
    {
        $this->spies[] = $spy;

        return $this;
    }

    /**
     * @return Spy[]
     */
    public function getSpies()
    {
        return $this->spies;
    }

    /**
     * @param CustomStmt $customStmt
     *
     * @return $this
     */
    public function addCustomStmt(CustomStmt $customStmt)
    {
        $this->customStmts[] = $customStmt;

        return $this;
    }

    /**
     * @return CustomStmt[]
     */
    public function getCustomStmts()
    {
        return $this->customStmts;
    }

    /**
     * @param Assert_ $assert
     *
     * @return $this
     */
    public function addAssert(Assert_ $assert)
    {
        $this->asserts[] = $assert;

        return $this;
    }

    /**
     * @return Assert_[]
     */
    public function getAsserts()
    {
        return $this->asserts;
    }
}
