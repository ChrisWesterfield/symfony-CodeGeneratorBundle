<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorService;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ServiceGeneratorUpdateDocumentAnnotationEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class ServiceGeneratorUpdateDocumentAnnotationEvent extends Event
{
    /**
     * @var CodeGeneratorService
     */
    protected $subject;

    /**
     * @var array
     */
    protected $fileArray;

    /**
     * @var array
     */
    protected $newFileArray;

    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $newFile;

    /**
     * @var CG\Service
     */
    protected $annotation;

    /**
     * @return array
     */
    public function getFileArray(): array
    {
        return $this->fileArray;
    }

    /**
     * @param array $fileArray
     *
     * @return ServiceGeneratorUpdateDocumentAnnotationEvent
     */
    public function setFileArray(array $fileArray): ServiceGeneratorUpdateDocumentAnnotationEvent
    {
        $this->fileArray = $fileArray;

        return $this;
    }

    /**
     * @return array
     */
    public function getNewFileArray(): array
    {
        return $this->newFileArray;
    }

    /**
     * @param array $newFileArray
     *
     * @return ServiceGeneratorUpdateDocumentAnnotationEvent
     */
    public function setNewFileArray(array $newFileArray): ServiceGeneratorUpdateDocumentAnnotationEvent
    {
        $this->newFileArray = $newFileArray;

        return $this;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file
     *
     * @return ServiceGeneratorUpdateDocumentAnnotationEvent
     */
    public function setFile(string $file): ServiceGeneratorUpdateDocumentAnnotationEvent
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return string
     */
    public function getNewFile(): string
    {
        return $this->newFile;
    }

    /**
     * @param string $newFile
     *
     * @return ServiceGeneratorUpdateDocumentAnnotationEvent
     */
    public function setNewFile(string $newFile): ServiceGeneratorUpdateDocumentAnnotationEvent
    {
        $this->newFile = $newFile;

        return $this;
    }

    /**
     * @return CG\Service
     */
    public function getAnnotation(): CG\Service
    {
        return $this->annotation;
    }

    /**
     * @param CG\Service $annotation
     *
     * @return ServiceGeneratorUpdateDocumentAnnotationEvent
     */
    public function setAnnotation(CG\Service $annotation
    ): ServiceGeneratorUpdateDocumentAnnotationEvent
    {
        $this->annotation = $annotation;

        return $this;
    }

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
     * @return ServiceGeneratorUpdateDocumentAnnotationEvent
     */
    public function setSubject(CodeGeneratorService $subject
    ): ServiceGeneratorUpdateDocumentAnnotationEvent
    {
        $this->subject = $subject;

        return $this;
    }

}
