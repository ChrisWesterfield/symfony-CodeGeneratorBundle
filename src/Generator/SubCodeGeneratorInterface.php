<?php
declare(strict_types = 1);

namespace MjrOne\CodeGeneratorBundle\Generator;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorInterface;

/**
 * Interface SubDriverInterface
 *
 * @package MjrOne\CodeGeneratorBundle\Generator
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
interface SubCodeGeneratorInterface extends CodeGeneratorInterface
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
     * @return SubCodeGeneratorInterface
     */
    public function setTemplateVariables(ArrayCollection $templateVariables):SubCodeGeneratorInterface;

    /**
     * @param array $config
     *
     * @return SubCodeGeneratorInterface
     */
    public function setConfig(array $config):SubCodeGeneratorInterface;

}
