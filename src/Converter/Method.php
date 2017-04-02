<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Converter;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class Method
 *
 * @package   MjrOne\CodeGeneratorBundle\Converter
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Method
{
    /**
     * @param string $source
     * @param array  $tokens
     *
     *  @return array;
     */
    public  function parseDocument(string $source,array $tokens)
    {
        $methods = [];

        return $methods;
    }
}
