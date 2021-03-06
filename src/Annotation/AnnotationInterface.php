<?php
declare(strict_types = 1);

namespace MjrOne\CodeGeneratorBundle\Annotation;
use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Interface AnnotationInterface
 *
 * @package MjrOne\CodeGeneratorBundle\Annotation
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
interface AnnotationInterface
{
    /**
     * @return array
     */
    public function toArray():array;
}
