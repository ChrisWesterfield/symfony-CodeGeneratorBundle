<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorEntityRepository;
use MjrOne\CodeGeneratorBundle\Php\Document\File;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EntityRepositoryGeneratorEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class EntityRepositoryGeneratorEvent extends Event
{
    /**
     * @var CodeGeneratorEntityRepository
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
     * @var File
     */
    public $fileContainer;

    /**
     * @return File
     */
    public function getFileContainer(): File
    {
        return $this->fileContainer;
    }

    /**
     * @param File $fileContainer
     * @return EntityRepositoryGeneratorEvent
     */
    public function setFileContainer(File $fileContainer): EntityRepositoryGeneratorEvent
    {
        $this->fileContainer = $fileContainer;
        return $this;
    }

    /**
     * @return CodeGeneratorEntityRepository
     */
    public function getSubject(): CodeGeneratorEntityRepository
    {
        return $this->subject;
    }

    /**
     * @param CodeGeneratorEntityRepository $subject
     *
     * @return EntityRepositoryGeneratorEvent
     */
    public function setSubject(CodeGeneratorEntityRepository $subject
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
