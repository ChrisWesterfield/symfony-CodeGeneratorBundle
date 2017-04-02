<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * interface UnitTestInterface
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
interface UnitTestInterface
{
    /**
     * @return mixed
     */
    public function getRenderedOutput();
}
