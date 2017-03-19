<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 13/03/2017
 * Time: 21:38
 */

namespace MjrOne\CodeGeneratorBundle\Services;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

interface CodeGeneratorInterface
{
    public function process();
}
