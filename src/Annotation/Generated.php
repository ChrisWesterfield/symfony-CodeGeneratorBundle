<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Annotation;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class Generated
 *
 * @package   MjrOne\CodeGeneratorBundle\Annotation
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS","ANNOTATION", "METHOD", "PROPERTY"})
 */
class Generated implements AnnotationInterface
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }
}
