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
 * Time: 18:53
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\Driver\Service\ServicePropertiesGenerator;
use Symfony\Component\EventDispatcher\Event;

class ServicePropertiesGeneratorEvent extends Event
{
    /**
     * @var ServicePropertiesGenerator
     */
    protected $subject;

    /**
     * @var ArrayCollection
     */
    protected $templateVariables;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var CG\Service\Property
     */
    protected $annotation;

    /**
     * @return \MjrOne\CodeGeneratorBundle\Services\Driver\Service\ServicePropertiesGenerator
     */
    public function getSubject(): \MjrOne\CodeGeneratorBundle\Services\Driver\Service\ServicePropertiesGenerator
    {
        return $this->subject;
    }

    /**
     * @param \MjrOne\CodeGeneratorBundle\Services\Driver\Service\ServicePropertiesGenerator $subject
     *
     * @return ServicePropertiesGeneratorEvent
     */
    public function setSubject(\MjrOne\CodeGeneratorBundle\Services\Driver\Service\ServicePropertiesGenerator $subject
    ): ServicePropertiesGeneratorEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTemplateVariables(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->templateVariables;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $templateVariables
     *
     * @return ServicePropertiesGeneratorEvent
     */
    public function setTemplateVariables(\Doctrine\Common\Collections\ArrayCollection $templateVariables
    ): ServicePropertiesGeneratorEvent
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
     * @return ServicePropertiesGeneratorEvent
     */
    public function setConfig(array $config): ServicePropertiesGeneratorEvent
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return \MjrOne\CodeGeneratorBundle\Annotation\Service\Property
     */
    public function getAnnotation(): \MjrOne\CodeGeneratorBundle\Annotation\Service\Property
    {
        return $this->annotation;
    }

    /**
     * @param \MjrOne\CodeGeneratorBundle\Annotation\Service\Property $annotation
     *
     * @return ServicePropertiesGeneratorEvent
     */
    public function setAnnotation(\MjrOne\CodeGeneratorBundle\Annotation\Service\Property $annotation
    ): ServicePropertiesGeneratorEvent
    {
        $this->annotation = $annotation;

        return $this;
    }
}
