<?php
declare(strict_types=1);
namespace MjrOne\CodeGeneratorBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class MJRCodeGeneratorBundle
 *
 * @package MjrOne\CodeGeneratorBundle
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 */
class MjrOneCodeGeneratorBundle extends Bundle
{
    const VERSION = '1.0.0';
    const GENERATOR_INSERT_STRING = 'Generatored by MJR.ONE CodeGenerator Bundle (Generator Copyright (c) by Chris Westerfield 2017, Licensed under LGPL V3)';
}
