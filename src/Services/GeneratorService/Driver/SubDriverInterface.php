<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 18/03/2017
 * Time: 14:56
 */

namespace MjrOne\CodeGeneratorBundle\Services\GeneratorService\Driver;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;

interface SubDriverInterface
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
