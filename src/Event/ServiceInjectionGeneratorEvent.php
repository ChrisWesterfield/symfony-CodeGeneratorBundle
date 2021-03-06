<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\Service\ServiceInjectionGenerator;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ServiceInjectionGeneratorEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class ServiceInjectionGeneratorEvent extends Event
{
    /**
     * @var ServiceInjectionGenerator
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
     * @return ServiceInjectionGenerator
     */
    public function getSubject(): ServiceInjectionGenerator
    {
        return $this->subject;
    }

    /**
     * @param ServiceInjectionGenerator $subject
     *
     * @return ServiceInjectionGeneratorEvent
     */
    public function setSubject(ServiceInjectionGenerator $subject
    ): ServiceInjectionGeneratorEvent
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
     * @return ServiceInjectionGeneratorEvent
     */
    public function setTemplateVars(ArrayCollection $templateVars
    ): ServiceInjectionGeneratorEvent
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
     * @return ServiceInjectionGeneratorEvent
     */
    public function setConfig(array $config): ServiceInjectionGeneratorEvent
    {
        $this->config = $config;

        return $this;
    }
}
