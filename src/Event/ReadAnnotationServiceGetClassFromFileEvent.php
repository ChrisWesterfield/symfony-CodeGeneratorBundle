<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 18/03/2017
 * Time: 01:46
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

class ReadAnnotationServiceGetClassFromFileEvent extends ReadAnnotationServiceConstructorEvent
{
    /**
     * @var string
     */
    protected $namespace;
    /**
     * @var string
     */
    protected $class;

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     *
     * @return ReadAnnotationServiceGetClassFromFileEvent
     */
    public function setNamespace(string $namespace): ReadAnnotationServiceGetClassFromFileEvent
    {
        $this->namespace = $namespace;

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
     * @return ReadAnnotationServiceGetClassFromFileEvent
     */
    public function setClass(string $class): ReadAnnotationServiceGetClassFromFileEvent
    {
        $this->class = $class;

        return $this;
    }
}