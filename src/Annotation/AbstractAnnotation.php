<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation;

/**
 * AbstractAnnotation
 * @package CodeGeneratorBundle\Annotation
 * @author    Chris Westerfield <chris@mjr.one>
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
    public function toArray():array
    {
        $json = json_encode($this);
        return json_decode($json,true);
    }
}
