<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class UnitObject
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\PhpUnit
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class UnitObject
{
    /**
     * @var CG\UnitTest
     */
    protected $annotation;

    /**
     * @var string
     */
    protected $methodName;

    /**
     * @var ArrayCollection
     */
    protected $templateVariable;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var ArrayCollection
     */
    protected $renderedCollection;

    public function __construct()
    {
        $this->renderedCollection = new ArrayCollection();
    }

    /**
     * @return CG\UnitTest
     */
    public function getAnnotation(): CG\UnitTest
    {
        return $this->annotation;
    }

    /**
     * @param CG\UnitTest $annotation
     *
     * @return UnitObject
     */
    public function setAnnotation(CG\UnitTest $annotation): UnitObject
    {
        $this->annotation = $annotation;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     *
     * @return UnitObject
     */
    public function setMethodName(string $methodName): UnitObject
    {
        $this->methodName = $methodName;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTemplateVariable(): ArrayCollection
    {
        return $this->templateVariable;
    }

    /**
     * @param ArrayCollection $templateVariable
     *
     * @return UnitObject
     */
    public function setTemplateVariable(ArrayCollection $templateVariable): UnitObject
    {
        $this->templateVariable = $templateVariable;

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
     * @return UnitObject
     */
    public function setConfig(array $config): UnitObject
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRenderedCollection(): ArrayCollection
    {
        return $this->renderedCollection;
    }

    /**
     * @param ArrayCollection $renderedCollection
     *
     * @return UnitObject
     */
    public function setRenderedCollection(ArrayCollection $renderedCollection): UnitObject
    {
        $this->renderedCollection = $renderedCollection;

        return $this;
    }
}
