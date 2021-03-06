<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Interface GeneratorInterface
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
interface CodeGeneratorInterface
{
    /**
     * @return void
     */
    public function process():void;
}
