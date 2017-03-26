<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation;

/**
 * AbstractAnnotation
 * @package CodeGeneratorBundle\Annotation
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 */
abstract class AbstractAnnotation
{
    const DRIVER = DriverInterface::class;
    /**
     * @return array
     */
    public function toArray()
    {
        return (array)$this;
    }
}
