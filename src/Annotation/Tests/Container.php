<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation\Tests;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit\ContainerGenerator;


/**
 * Class Container
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation\Tests
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   GNU Lesser General Public License
 * @Annotation
 * @Target({"CLASS","ANNOTATION"})
 */
class Container extends CG\AbstractAnnotation implements CG\SubDriverInterface, CG\ClassInterface, CG\PropertyInterface
{
    const DRIVER = ContainerGenerator::class;

    /**
     * @var  string
     */
    public $name;

    /**
     * @var string
     */
    public $container;

    /**
     * @var string
     */
    public $mock;

    /**
     * @var string
     */
    public $class;

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
     * @return Container
     */
    public function setName(string $name): Container
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getContainer(): string
    {
        return $this->container;
    }

    /**
     * @param string $container
     *
     * @return Container
     */
    public function setContainer(string $container): Container
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return string
     */
    public function getMock(): string
    {
        return $this->mock;
    }

    /**
     * @param string $mock
     *
     * @return Container
     */
    public function setMock(string $mock): Container
    {
        $this->mock = $mock;

        return $this;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return Container
     */
    public function setClass(string $class): Container
    {
        $this->class = $class;

        return $this;
    }
}