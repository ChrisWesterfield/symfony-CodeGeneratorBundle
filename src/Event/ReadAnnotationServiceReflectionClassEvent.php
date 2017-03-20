<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 18/03/2017
 * Time: 01:30
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use ReflectionClass;

class ReadAnnotationServiceReflectionClassEvent extends ReadAnnotationServiceConstructorEvent
{
    /**
     * @var ReflectionClass
     */
    protected $reflectionClass;

    /**
     * @return ReflectionClass
     */
    public function getReflectionClass(): ReflectionClass
    {
        return $this->reflectionClass;
    }

    /**
     * @param ReflectionClass $reflectionClass
     *
     * @return ReadAnnotationServiceReflectionClassEvent
     */
    public function setReflectionClass(ReflectionClass $reflectionClass): ReadAnnotationServiceReflectionClassEvent
    {
        $this->reflectionClass = $reflectionClass;

        return $this;
    }
}
