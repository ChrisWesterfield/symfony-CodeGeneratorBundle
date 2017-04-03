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
 * @Target({"CLASS","ANNOTATION", "METHOD"})
 */
final class TestFunction extends CG\AbstractAnnotation implements CG\SubDriverInterface, CG\ClassInterface, CG\MethodInterface
{
    const DRIVER = FunctionGenerator::class;
    /**
     * @var bool
     */
    public $ignore=false;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $dataProvider;

    /**
     * @var string
     */
    public $depends;

    /**
     * @return string
     */
    public function getDataProvider(): string
    {
        return $this->dataProvider;
    }

    /**
     * @param string $dataProvider
     *
     * @return TestFunction
     */
    public function setDataProvider(string $dataProvider): TestFunction
    {
        $this->dataProvider = $dataProvider;

        return $this;
    }

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
     * @return TestFunction
     */
    public function setIgnore(bool $ignore): TestFunction
    {
        $this->ignore = $ignore;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return TestFunction
     */
    public function setName(string $name): TestFunction
    {
        $this->name = $name;

        return $this;
    }
}
