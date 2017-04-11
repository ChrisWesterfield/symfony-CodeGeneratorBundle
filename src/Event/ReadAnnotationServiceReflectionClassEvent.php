<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use ReflectionClass;

/**
 * Class ReadAnnotationServiceReflectionClassEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
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
