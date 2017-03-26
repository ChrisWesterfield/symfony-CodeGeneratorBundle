<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\CodeGenerators\Driver;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Interface GeneratorInterface
 *
 * @package   MjrOne\CodeGeneratorBundle\CodeGenerators\Driver
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
interface GeneratorInterface
{
    /**
     * @return mixed
     */
    public function process();
}
