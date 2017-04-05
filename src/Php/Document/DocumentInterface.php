<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class DocumentInterface
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   LGPL V3
 * @link      http://www.mjr.one
 */
interface DocumentInterface
{

    /**
     * @return DocumentInterface
     */
    public function setUpdateNeeded():DocumentInterface;

    /**
     * @return bool
     */
    public function isUpdateNeeded():bool ;
}
