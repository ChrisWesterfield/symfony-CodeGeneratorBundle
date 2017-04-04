<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Tests;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Generator\PhpUnit\DataProviderCodeGenerator;

/**
 * Class DataProvider
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation\Tests
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS","ANNOTATION"})
 */
final class DataProvider extends CG\AbstractAnnotation implements CG\SubDriverInterface, CG\ClassInterface, CG\PropertyInterface
{
    const DRIVER = DataProviderCodeGenerator::class;
    /**
     * @var string
     */
    public $name;

    /**
     * @var string|null
     */
    public $methodName;

    /**
     * @var array
     */
    public $data;

    /**
     * @var bool
     */
    public $ignore=false;

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
     * @return DataProvider
     */
    public function setIgnore(bool $ignore): DataProvider
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
     * @return DataProvider
     */
    public function setName(string $name): DataProvider
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @param null|string $methodName
     *
     * @return DataProvider
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array|null $data
     *
     * @return DataProvider
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
