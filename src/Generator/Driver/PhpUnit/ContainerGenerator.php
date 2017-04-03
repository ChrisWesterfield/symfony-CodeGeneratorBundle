<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Document\RenderedOutput;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorDriverInterface;


/**
 * Class ContainerGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   GNU Lesser General Public License
 */
class ContainerGenerator extends GeneratorAbstract implements GeneratorDriverInterface, UnitTestInterface
{
    /**
     * @return void
     */
    public function process(): void
    {
        // TODO: Implement process() method.
    }
}