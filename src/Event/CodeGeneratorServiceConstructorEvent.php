<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorService;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class CodeGeneratorServiceConstructorEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class CodeGeneratorServiceConstructorEvent extends Event
{
    /**
     * @var CodeGeneratorService
     */
    protected $subject;

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
     * @return CodeGeneratorServiceConstructorEvent
     */
    public function setSubject(CodeGeneratorService $subject
    ): CodeGeneratorServiceConstructorEvent
    {
        $this->subject = $subject;

        return $this;
    }
}
