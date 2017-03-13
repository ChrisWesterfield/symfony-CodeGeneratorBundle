<?php
declare(strict_types=1);
/**
 * @author    Christopher Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield
 * @author    Christopher Westerfield <chris@mjr.one>
 * @license   MJR.ONE Source License
 * Date: 03/12/2016
 * Time: 15:40
 */
namespace MJR\CodeGeneratorBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class MJRCodeGeneratorBundle
 *
 * @package MJR\CodeGeneratorBundle
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 */
class MjrOneCodeGeneratorBundle extends Bundle
{
    const VERSION = '1.0.0';
    const GENERATOR_INSERT_STRING = 'Generatored by MJR.ONE CodeGenerator Bundle (Copyright (c) by Chris Westerfield 2017)';
}
