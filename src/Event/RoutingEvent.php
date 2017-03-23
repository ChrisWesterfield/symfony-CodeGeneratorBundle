<?php
declare(strict_types=1);
/**
 * @author    Christopher Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 24/03/2017
 * Time: 00:12
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\RouterService;
use Symfony\Component\EventDispatcher\Event;

class RoutingEvent extends Event
{
    /**
     * @var RouterService
     */
    protected $subject;

    /**
     * @var array
     */
    protected $production;

    /**
     * @var array
     */
    protected $development;

    /**
     * @var array
     */
    protected $currentConfig;

    /**
     * @var string
     */
    protected $content;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return RoutingEvent
     */
    public function setContent(string $content): RoutingEvent
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return array
     */
    public function getProduction(): array
    {
        return $this->production;
    }

    /**
     * @param array $production
     *
     * @return RoutingEvent
     */
    public function setProduction(array $production): RoutingEvent
    {
        $this->production = $production;

        return $this;
    }

    /**
     * @return array
     */
    public function getDevelopment(): array
    {
        return $this->development;
    }

    /**
     * @param array $development
     *
     * @return RoutingEvent
     */
    public function setDevelopment(array $development): RoutingEvent
    {
        $this->development = $development;

        return $this;
    }

    /**
     * @return array
     */
    public function getCurrentConfig(): array
    {
        return $this->currentConfig;
    }

    /**
     * @param array $currentConfig
     *
     * @return RoutingEvent
     */
    public function setCurrentConfig(array $currentConfig): RoutingEvent
    {
        $this->currentConfig = $currentConfig;

        return $this;
    }

    /**
     * @return RouterService
     */
    public function getSubject(): RouterService
    {
        return $this->subject;
    }

    /**
     * @param RouterService $subject
     *
     * @return RoutingEvent
     */
    public function setSubject(RouterService $subject): RoutingEvent
    {
        $this->subject = $subject;

        return $this;
    }

}
