<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorService;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ServiceGeneratorEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class ServiceGeneratorEvent extends Event
{
    /**
     * @var CodeGeneratorService
     */
    protected $subject;

    /**
     * @var ArrayCollection
     */
    protected $templateVars;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $content;

    /**
     * @return CodeGeneratorService
     */
    public function getSubject(): CodeGeneratorService
    {
        return $this->subject;
    }

    /**
     * @param CodeGeneratorService $subject
     *
     * @return ServiceGeneratorEvent
     */
    public function setSubject(CodeGeneratorService $subject
    ): ServiceGeneratorEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTemplateVars(): ArrayCollection
    {
        return $this->templateVars;
    }

    /**
     * @param ArrayCollection $templateVars
     *
     * @return ServiceGeneratorEvent
     */
    public function setTemplateVars(ArrayCollection $templateVars): ServiceGeneratorEvent
    {
        $this->templateVars = $templateVars;

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
     * @return ServiceGeneratorEvent
     */
    public function setConfig(array $config): ServiceGeneratorEvent
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return ServiceGeneratorEvent
     */
    public function setContent(string $content): ServiceGeneratorEvent
    {
        $this->content = $content;

        return $this;
    }
}
