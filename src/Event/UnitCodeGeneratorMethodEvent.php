<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Generator\PhpUnit\UnitCodeGenerator;
use MjrOne\CodeGeneratorBundle\Php\Document\Method;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class UnitCodeGeneratorMethodEvent
 * @package MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class UnitCodeGeneratorMethodEvent extends Event
{
    /**
     * @var UnitCodeGenerator
     */
    protected $subject;

    /**
     * @var Method
     */
    protected $method;

    /**
     * @var Method
     */
    protected $fileMethod;

    /**
     * @return UnitCodeGenerator
     */
    public function getSubject(): UnitCodeGenerator
    {
        return $this->subject;
    }

    /**
     * @param UnitCodeGenerator $subject
     * @return UnitCodeGeneratorMethodEvent
     */
    public function setSubject(UnitCodeGenerator $subject): UnitCodeGeneratorMethodEvent
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return Method
     */
    public function getMethod(): Method
    {
        return $this->method;
    }

    /**
     * @param Method $method
     * @return UnitCodeGeneratorMethodEvent
     */
    public function setMethod(Method $method): UnitCodeGeneratorMethodEvent
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return Method
     */
    public function getFileMethod(): Method
    {
        return $this->fileMethod;
    }

    /**
     * @param Method $fileMethod
     * @return UnitCodeGeneratorMethodEvent
     */
    public function setFileMethod(Method $fileMethod): UnitCodeGeneratorMethodEvent
    {
        $this->fileMethod = $fileMethod;
        return $this;
    }
}