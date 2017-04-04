<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\PhpUnit;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorAbstract as CoreAbstractGenerator;

/**
 * Class GeneratorAbstract
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\PhpUnit
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 */
abstract class CodeGeneratorAbstract extends CoreAbstractGenerator
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
     * @var
     */
    protected $renderedOutput;

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
     * @return CodeGeneratorAbstract
     */
    public function setTemplateVariables(ArrayCollection $templateVariables
    ): CodeGeneratorAbstract
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
     * @return CodeGeneratorAbstract
     */
    public function setConfig(array $config): CodeGeneratorAbstract
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRenderedOutput()
    {
        return $this->renderedOutput;
    }

    /**
     * @param mixed $renderedOutput
     *
     * @return CodeGeneratorAbstract
     */
    public function setRenderedOutput($renderedOutput)
    {
        $this->renderedOutput = $renderedOutput;

        return $this;
    }
}
