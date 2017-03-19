<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 15/03/2017
 * Time: 23:28
 */

namespace MjrOne\CodeGeneratorBundle\Services;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\RenderServiceEvent;
use Twig_Environment;

/**
 * Class RenderService
 *
 * @package MjrOne\CodeGeneratorBundle\Services
 */
class RenderService
{
    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * @var EventDispatcherService
     */
    protected $eventService;

    /**
     * RenderService constructor.
     *
     * @param Twig_Environment       $twig
     * @param EventDispatcherService $ed
     */
    public function __construct(Twig_Environment $twig, EventDispatcherService $ed)
    {
        $this->twig = $twig;
        $this->eventService = $ed;
    }

    /**
     * @param $template
     * @param $variables
     *
     * @return string
     */
    public function renderTemplate($template, $variables)
    {
        $event = (new RenderServiceEvent())->setSubject($this)->setTemplate($template)->setVars($variables);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preRender'),$event);
        $event->setContent($this->twig->render($event->getTemplate(), $event->getVars()));
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'postRender'),$event);
        return $event->getContent();
    }

    /**
     * @return Twig_Environment
     */
    public function getRaw()
    {
        return $this->twig;
    }

    /**
     * @return Twig_Environment
     */
    public function getTwig(): Twig_Environment
    {
        return $this->twig;
    }

    /**
     * @param Twig_Environment $twig
     *
     * @return RenderService
     */
    public function setTwig(Twig_Environment $twig): RenderService
    {
        $this->twig = $twig;

        return $this;
    }

    /**
     * @return EventDispatcherService
     */
    public function getED()
    {
        return $this->getEventService();
    }

    /**
     * @return EventDispatcherService
     */
    public function getEventService(): EventDispatcherService
    {
        return $this->eventService;
    }

    /**
     * @param EventDispatcherService $eventService
     *
     * @return RenderService
     */
    public function setEventService(EventDispatcherService $eventService
    ): RenderService
    {
        $this->eventService = $eventService;

        return $this;
    }
}
