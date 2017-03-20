<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 18/03/2017
 * Time: 01:08
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\Driver\GeneratorInterface;
use Symfony\Component\EventDispatcher\Event;

class EventAbstract extends Event
{
    /**
     * @var GeneratorInterface
     */
    protected $subject;

    public function __construct(GeneratorInterface $generator)
    {
        $this->subject = $generator;
    }

    /**
     * @return GeneratorInterface
     */
    public function getSubject(): GeneratorInterface
    {
        return $this->subject;
    }

    /**
     * @param GeneratorInterface $subject
     *
     * @return EventAbstract
     */
    public function setSubject(GeneratorInterface $subject): EventAbstract
    {
        $this->subject = $subject;

        return $this;
    }

}
