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
 * Time: 00:58
 */

namespace MjrOne\CodeGeneratorBundle\Services;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventDispatcherService
{

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $class
     * @param string $property
     *
     * @return mixed
     */
    public function getEventName(string $class,string $property)
    {
        return str_replace('\\','.',$class.'.'.$property);
    }

    /**
     * Dispatch Event
     *
     * @param string $event
     * @param Event $object
     *
     * @return \Symfony\Component\EventDispatcher\Event
     */
    public function dispatch(string $event,Event $object)
    {
        $this->getEventDispatcher()->dispatch($event,$object);
        return $object;
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getEventDispatcher(): \Symfony\Component\EventDispatcher\EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }
}
