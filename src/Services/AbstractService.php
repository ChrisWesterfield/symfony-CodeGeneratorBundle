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
 * Time: 21:41
 */

namespace MjrOne\CodeGeneratorBundle\Services;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractService
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
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return \MjrOne\CodeGeneratorBundle\Services\AbstractService
     */
    public function setInput(InputInterface $input):AbstractService
    {
        $this->input = $input;
        return $this;
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return \MjrOne\CodeGeneratorBundle\Services\AbstractService
     */
    public function setOutput(OutputInterface $output):AbstractService
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @return \Symfony\Component\Console\Input\InputInterface
     */
    public function getInput(): \Symfony\Component\Console\Input\InputInterface
    {
        return $this->input;
    }

    /**
     * @return \Symfony\Component\Console\Output\OutputInterface
     */
    public function getOutput(): \Symfony\Component\Console\Output\OutputInterface
    {
        return $this->output;
    }
}
