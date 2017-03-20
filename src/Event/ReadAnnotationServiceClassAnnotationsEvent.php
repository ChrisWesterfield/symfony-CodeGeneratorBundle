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

class ReadAnnotationServiceClassAnnotationsEvent extends ReadAnnotationServiceConstructorEvent
{
    /**
     * @var array
     */
    public $annotations;

    /**
     * @return array
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * @param array $annotations
     *
     * @return ReadAnnotationServiceClassAnnotationsEvent
     */
    public function setAnnotations($annotations):ReadAnnotationServiceClassAnnotationsEvent
    {
        $this->annotations = $annotations;

        return $this;
    }
}
