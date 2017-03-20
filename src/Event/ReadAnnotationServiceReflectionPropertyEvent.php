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
 * Time: 01:42
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use ReflectionProperty;

class ReadAnnotationServiceReflectionPropertyEvent extends ReadAnnotationServiceConstructorEvent
{

    /**
     * @var ReflectionProperty
     */
    protected $reflectionProperty;

    /**
     * @return \ReflectionProperty
     */
    public function getReflectionProperty(): \ReflectionProperty
    {
        return $this->reflectionProperty;
    }

    /**
     * @param \ReflectionProperty $reflectionProperty
     *
     * @return ReadAnnotationServiceReflectionPropertyEvent
     */
    public function setReflectionProperty(\ReflectionProperty $reflectionProperty
    ): ReadAnnotationServiceReflectionPropertyEvent
    {
        $this->reflectionProperty = $reflectionProperty;

        return $this;
    }
}
