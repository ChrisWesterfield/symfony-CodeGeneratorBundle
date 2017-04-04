<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\PhpUnit;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Document\RenderedOutput;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorInterface;


/**
 * Class ContainerGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\PhpUnit
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   GNU Lesser General Public License
 */
class ContainerCodeGenerator extends CodeGeneratorAbstract implements CodeGeneratorInterface, UnitTestInterface
{
    /**
     * @return void
     */
    public function process(): void
    {
        // TODO: Implement process() method.
    }
}
