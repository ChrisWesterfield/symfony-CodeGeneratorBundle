<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class ParsedChildInterface
 * @package MjrOne\CodeGeneratorBundle\Php\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   LGPL V3
 * @link      http://www.mjr.one
 */
interface ParsedChildInterface
{
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param DocumentInterface|null $parent
     * @return DocumentAbstract
     */
    public function setParent($parent);
}