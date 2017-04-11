<?php
declare(strict_types = 1);

namespace MjrOne\CodeGeneratorBundle\Generator\Service;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorAbstract;
use MjrOne\CodeGeneratorBundle\Generator\SubCodeGeneratorInterface;

/**
 * Class SubGeneratorAbstract
 *
 * @package MjrOne\CodeGeneratorBundle\Generator\Service
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
abstract class SubCodeGeneratorAbstract extends CodeGeneratorAbstract
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
     * @return SubCodeGeneratorInterface|SubCodeGeneratorAbstract
     */
    public function setTemplateVariables(ArrayCollection $templateVariables): SubCodeGeneratorInterface
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
     * @return SubCodeGeneratorInterface|SubCodeGeneratorAbstract
     */
    public function setConfig(array $config): SubCodeGeneratorInterface
    {
        $this->config = $config;

        return $this;
    }

}
