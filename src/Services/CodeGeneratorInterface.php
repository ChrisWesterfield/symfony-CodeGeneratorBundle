<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Services;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Interface CodeGeneratorInterface
 *
 * @package   MjrOne\CodeGeneratorBundle\Services
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
    public function process();

    /**
     * @param InputInterface $input
     *
     * @return mixed
     */
    public function setInput(InputInterface $input);
}
