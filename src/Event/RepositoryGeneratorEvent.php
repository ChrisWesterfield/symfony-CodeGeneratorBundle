<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 20/03/2017
 * Time: 00:26
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\GeneratorService\Driver\RepositoryGenerator;
use Symfony\Component\EventDispatcher\Event;

class RepositoryGeneratorEvent extends Event
{
    /**
     * @var RepositoryGenerator
     */
    public $subject;

    /**
     * @var ArrayCollection
     */
    public $templateVariable;

    /**
     * @var string
     */
    public $content;

    /**
     * @var array
     */
    public $config;

    /**
     * @var string
     */
    public $entityClassName;

    /**
     * @return RepositoryGenerator
     */
    public function getSubject(): RepositoryGenerator
    {
        return $this->subject;
    }

    /**
     * @param RepositoryGenerator $subject
     *
     * @return RepositoryGeneratorEvent
     */
    public function setSubject(RepositoryGenerator $subject
    ): RepositoryGeneratorEvent
    {
        $this->subject = $subject;

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
     * @param array $templateVariable
     *
     * @return RepositoryGeneratorEvent
     */
    public function setTemplateVariable(ArrayCollection $templateVariable): RepositoryGeneratorEvent
    {
        $this->templateVariable = $templateVariable;

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
     * @return RepositoryGeneratorEvent
     */
    public function setContent(string $content): RepositoryGeneratorEvent
    {
        $this->content = $content;

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
     * @return RepositoryGeneratorEvent
     */
    public function setConfig(array $config): RepositoryGeneratorEvent
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityClassName(): string
    {
        return $this->entityClassName;
    }

    /**
     * @param string $entityClassName
     *
     * @return RepositoryGeneratorEvent
     */
    public function setEntityClassName(string $entityClassName): RepositoryGeneratorEvent
    {
        $this->entityClassName = $entityClassName;

        return $this;
    }
}
