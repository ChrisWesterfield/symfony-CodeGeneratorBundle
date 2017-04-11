<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Generator\PhpUnit\UnitCodeGenerator;
use MjrOne\CodeGeneratorBundle\Php\Document\File;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class UnitCodeGeneratorEvent
 * @package MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class UnitCodeGeneratorEvent extends Event
{
    /**
     * @var UnitCodeGenerator
     */
    protected $subject;

    /**
     * @var string
     */
    protected $traitNameSpace;

    /**
     * @var string
     */
    protected $basePathTest;

    /**
     * @var string
     */
    protected $fileNameSpace;

    /**
     * @var array
     */
    protected $writeTestClassParameter;

    /**
     * @var File
     */
    protected $fileContainer;

    /**
     * @var array
     */
    protected $templateVariables;

    /**
     * @var string|null
     */
    protected $rendered;

    /**
     * @var string|null
     */
    protected $fullPath;

    /**
     * @var string|null
     */
    protected $fileName;

    /**
     * @var ArrayCollection|string[]|null
     */
    protected $traitMethods;

    /**
     * @return ArrayCollection|null|\string[]
     */
    public function getTraitMethods()
    {
        return $this->traitMethods;
    }

    /**
     * @param ArrayCollection|null|\string[] $traitMethods
     * @return UnitCodeGeneratorEvent
     */
    public function setTraitMethods(ArrayCollection $traitMethods)
    {
        $this->traitMethods = $traitMethods;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param null|string $fileName
     * @return UnitCodeGeneratorEvent
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFullPath()
    {
        return $this->fullPath;
    }

    /**
     * @param null|string $fullPath
     * @return UnitCodeGeneratorEvent
     */
    public function setFullPath($fullPath)
    {
        $this->fullPath = $fullPath;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getRendered()
    {
        return $this->rendered;
    }

    /**
     * @param null|string $rendered
     * @return UnitCodeGeneratorEvent
     */
    public function setRendered($rendered)
    {
        $this->rendered = $rendered;
        return $this;
    }

    /**
     * @return array
     */
    public function getTemplateVariables(): array
    {
        return $this->templateVariables;
    }

    /**
     * @param array $templateVariables
     * @return UnitCodeGeneratorEvent
     */
    public function setTemplateVariables(array $templateVariables): UnitCodeGeneratorEvent
    {
        $this->templateVariables = $templateVariables;
        return $this;
    }

    /**
     * @return File
     */
    public function getFileContainer(): File
    {
        return $this->fileContainer;
    }

    /**
     * @param File $fileContainer
     * @return UnitCodeGeneratorEvent
     */
    public function setFileContainer(File $fileContainer): UnitCodeGeneratorEvent
    {
        $this->fileContainer = $fileContainer;
        return $this;
    }

    /**
     * @return array
     */
    public function getWriteTestClassParameter(): array
    {
        return $this->writeTestClassParameter;
    }

    /**
     * @param array $writeTestClassParameter
     * @return UnitCodeGeneratorEvent
     */
    public function setWriteTestClassParameter(array $writeTestClassParameter): UnitCodeGeneratorEvent
    {
        $this->writeTestClassParameter = $writeTestClassParameter;
        return $this;
    }

    /**
     * @return UnitCodeGenerator
     */
    public function getSubject(): UnitCodeGenerator
    {
        return $this->subject;
    }

    /**
     * @param UnitCodeGenerator $subject
     * @return UnitCodeGeneratorEvent
     */
    public function setSubject(UnitCodeGenerator $subject): UnitCodeGeneratorEvent
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getTraitNameSpace(): string
    {
        return $this->traitNameSpace;
    }

    /**
     * @param string $traitNameSpace
     * @return UnitCodeGeneratorEvent
     */
    public function setTraitNameSpace(string $traitNameSpace): UnitCodeGeneratorEvent
    {
        $this->traitNameSpace = $traitNameSpace;
        return $this;
    }

    /**
     * @return string
     */
    public function getBasePathTest(): string
    {
        return $this->basePathTest;
    }

    /**
     * @param string $basePathTest
     * @return UnitCodeGeneratorEvent
     */
    public function setBasePathTest(string $basePathTest): UnitCodeGeneratorEvent
    {
        $this->basePathTest = $basePathTest;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileNameSpace(): string
    {
        return $this->fileNameSpace;
    }

    /**
     * @param string $fileNameSpace
     * @return UnitCodeGeneratorEvent
     */
    public function setFileNameSpace(string $fileNameSpace): UnitCodeGeneratorEvent
    {
        $this->fileNameSpace = $fileNameSpace;
        return $this;
    }
}