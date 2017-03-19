<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 19/03/2017
 * Time: 17:41
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\Driver\ServiceGenerator;
use Symfony\Component\EventDispatcher\Event;

class ServiceGeneratorEvent extends Event
{
    /**
     * @var ServiceGenerator
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
     * @return ServiceGenerator
     */
    public function getSubject(): ServiceGenerator
    {
        return $this->subject;
    }

    /**
     * @param ServiceGenerator $subject
     *
     * @return ServiceGeneratorEvent
     */
    public function setSubject(ServiceGenerator $subject
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