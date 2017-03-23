<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 14/03/2017
 * Time: 00:14
 */

namespace MjrOne\CodeGeneratorBundle\Services\GeneratorService\Driver;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

interface GeneratorInterface
{
    /**
     * @return mixed
     */
    public function process();
}
