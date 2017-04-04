<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EventAbstract
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class EventAbstract extends Event
{
    /**
     * @var CodeGeneratorInterface
     */
    protected $subject;

    public function __construct(CodeGeneratorInterface $generator)
    {
        $this->subject = $generator;
    }

    /**
     * @return CodeGeneratorInterface
     */
    public function getSubject(): CodeGeneratorInterface
    {
        return $this->subject;
    }

    /**
     * @param CodeGeneratorInterface $subject
     *
     * @return EventAbstract
     */
    public function setSubject(CodeGeneratorInterface $subject): EventAbstract
    {
        $this->subject = $subject;

        return $this;
    }

}
