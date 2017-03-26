<?php
declare(strict_types = 1);

namespace MjrOne\CodeGeneratorBundle\CodeGenerators\Driver\Service;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\CodeGenerators\Driver\GeneratorAbstract;
use MjrOne\CodeGeneratorBundle\CodeGenerators\Driver\SubDriverInterface;

/**
 * Class SubGeneratorAbstract
 *
 * @package MjrOne\CodeGeneratorBundle\CodeGenerators\Driver\Service
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
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
     * @return SubDriverInterface|SubGeneratorAbstract
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
     * @return SubDriverInterface|SubGeneratorAbstract
     */
    public function setConfig(array $config): SubDriverInterface
    {
        $this->config = $config;

        return $this;
    }

}
