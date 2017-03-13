<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation\Service;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;

/**
 * Class Alias
 * @package CodeGeneratorBundle\Annotation\Service
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @package codegenerator\Annotation
 * @Annotation
 * @Target({"CLASS"})
 */
final class Alias extends AbstractAnnotation
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $alias;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Alias
     */
    public function setName(string $name): Alias
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     * @return Alias
     */
    public function setAlias(string $alias): Alias
    {
        $this->alias = $alias;
        return $this;
    }
}
