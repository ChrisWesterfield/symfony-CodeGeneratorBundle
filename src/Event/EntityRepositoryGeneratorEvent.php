<?php
declare(strict_types = 1);
/**
 * @author    Christopher Westerfield <chris.westerfield@spectware.com>
 * @link      https://www.spectware.com
 * @copyright Spectware, Inc.
 * @license   SpectwarePro Source License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 20/03/2017
 * Time: 00:26
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\Driver\EntityRepositoryGenerator;
use Symfony\Component\EventDispatcher\Event;

class EntityRepositoryGeneratorEvent extends Event
{
    /**
     * @var EntityRepositoryGenerator
     */
    public $subject;

    /**
     * @var array
     */
    public $templateVariable;

    /**
     * @var string
     */
    public $content;

    /**
     * @return EntityRepositoryGenerator
     */
    public function getSubject(): EntityRepositoryGenerator
    {
        return $this->subject;
    }

    /**
     * @param EntityRepositoryGenerator $subject
     *
     * @return EntityRepositoryGeneratorEvent
     */
    public function setSubject(EntityRepositoryGenerator $subject
    ): EntityRepositoryGeneratorEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return array
     */
    public function getTemplateVariable(): array
    {
        return $this->templateVariable;
    }

    /**
     * @param array $templateVariable
     *
     * @return EntityRepositoryGeneratorEvent
     */
    public function setTemplateVariable(array $templateVariable): EntityRepositoryGeneratorEvent
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
     * @return EntityRepositoryGeneratorEvent
     */
    public function setContent(string $content): EntityRepositoryGeneratorEvent
    {
        $this->content = $content;

        return $this;
    }
}
