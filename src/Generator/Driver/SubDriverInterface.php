<?php
declare(strict_types = 1);

namespace MjrOne\CodeGeneratorBundle\Generator\Driver;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorDriverInterface;

/**
 * Interface SubDriverInterface
 *
 * @package MjrOne\CodeGeneratorBundle\Generator\Driver
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
interface SubDriverInterface extends GeneratorDriverInterface
{
    /**
     * @return void
     */
    public function process():void;

    /**
     * @return ArrayCollection
     */
    public function getTemplateVariables(): ArrayCollection;

    /**
     * @return array
     */
    public function getConfig();

    /**
     * @param ArrayCollection $templateVariables
     *
     * @return SubDriverInterface
     */
    public function setTemplateVariables(ArrayCollection $templateVariables):SubDriverInterface;

    /**
     * @param array $config
     *
     * @return SubDriverInterface
     */
    public function setConfig(array $config):SubDriverInterface;

}
