<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorDriverInterface;
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
     * @var GeneratorDriverInterface
     */
    protected $subject;

    public function __construct(GeneratorDriverInterface $generator)
    {
        $this->subject = $generator;
    }

    /**
     * @return GeneratorDriverInterface
     */
    public function getSubject(): GeneratorDriverInterface
    {
        return $this->subject;
    }

    /**
     * @param GeneratorDriverInterface $subject
     *
     * @return EventAbstract
     */
    public function setSubject(GeneratorDriverInterface $subject): EventAbstract
    {
        $this->subject = $subject;

        return $this;
    }

}
