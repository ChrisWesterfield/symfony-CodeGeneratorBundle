<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Tests;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit\FunctionGenerator;

/**
 * Class FunctionDefinition
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation\Tests
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS","ANNOTATION", "METHODS"})
 */
final class FunctionDefinition implements CG\SubDriverInterface, CG\ClassInterface, CG\MethodInterface
{
    const DRIVER = FunctionGenerator::class;
    /**
     * @var bool
     */
    public $ignore=false;

    /**
     * @var string
     */
    public $testName;

    /**
     * @return bool
     */
    public function isIgnore(): bool
    {
        return $this->ignore;
    }

    /**
     * @param bool $ignore
     *
     * @return FunctionDefinition
     */
    public function setIgnore(bool $ignore): FunctionDefinition
    {
        $this->ignore = $ignore;

        return $this;
    }

    /**
     * @return string
     */
    public function getTestName(): string
    {
        return $this->testName;
    }

    /**
     * @param string $testName
     *
     * @return FunctionDefinition
     */
    public function setTestName(string $testName): FunctionDefinition
    {
        $this->testName = $testName;

        return $this;
    }
}
