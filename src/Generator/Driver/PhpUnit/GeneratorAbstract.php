<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class GeneratorAbstract
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 */
abstract class GeneratorAbstract
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
     * @return GeneratorAbstract
     */
    public function setTemplateVariables(ArrayCollection $templateVariables
    ): GeneratorAbstract
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
     * @return GeneratorAbstract
     */
    public function setConfig(array $config): GeneratorAbstract
    {
        $this->config = $config;

        return $this;
    }
}
