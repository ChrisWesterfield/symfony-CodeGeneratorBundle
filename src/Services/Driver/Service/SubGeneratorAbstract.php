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
 * Time: 17:25
 */

namespace MjrOne\CodeGeneratorBundle\Services\Driver\Service;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\Driver\GeneratorAbstract;
use MjrOne\CodeGeneratorBundle\Services\Driver\SubDriverInterface;

abstract class SubGeneratorAbstract extends GeneratorAbstract
{
    /**
     * @var ArrayCollection
     */
    protected $templateVariables;
    /**
     * @var array
     */
    protected $config;

    /**
     * @return ArrayCollection
     */
    public function getTemplateVariables(): ArrayCollection
    {
        return $this->templateVariables;
    }

    /**
     * @param ArrayCollection $templateVariables
     *
     * @return SubDriverInterface
     */
    public function setTemplateVariables(ArrayCollection $templateVariables): SubDriverInterface
    {
        $this->templateVariables = $templateVariables;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     *
     * @return SubDriverInterface
     */
    public function setConfig(array $config): SubDriverInterface
    {
        $this->config = $config;

        return $this;
    }

}
