<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Services;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class EventDispatcherService
 *
 * @package   MjrOne\CodeGeneratorBundle\Services
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class EventDispatcherService
{

    /**
     * @var EventDispatcherInterface
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
    public function getEventName(string $class, string $property)
    {
        $eventName = str_replace('\\', '.', $class . '.' . $property);
        $eventName = strtolower($eventName);
        return $eventName;
    }

    /**
     * Dispatch Event
     *
     * @param string $event
     * @param Event  $object
     *
     * @return \Symfony\Component\EventDispatcher\Event
     */
    public function dispatch(string $event, Event $object)
    {
        $this->getEventDispatcher()->dispatch($event, $object);

        return $object;
    }

    /**
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }
}
