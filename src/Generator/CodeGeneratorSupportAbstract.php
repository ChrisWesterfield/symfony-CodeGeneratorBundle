<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractService
 *
 * @package   MjrOne\CodeGeneratorBundle
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
abstract class CodeGeneratorSupportAbstract
{
    /**
     * @var InputInterface
     */
    protected $input;
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @param InputInterface $input
     *
     * @return CodeGeneratorSupportAbstract
     */
    public function setInput(InputInterface $input): CodeGeneratorSupportAbstract
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @param OutputInterface $output
     *
     * @return CodeGeneratorSupportAbstract
     */
    public function setOutput(OutputInterface $output): CodeGeneratorSupportAbstract
    {
        $this->output = $output;

        return $this;
    }

    /**
     * @return InputInterface
     */
    public function getInput(): InputInterface
    {
        return $this->input;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface
    {
        return $this->output;
    }
}
