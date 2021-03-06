<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\RouteGenerator;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class RoutingEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class RoutingEvent extends Event
{
    /**
     * @var RouteGenerator
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
     * @return RouteGenerator
     */
    public function getSubject(): RouteGenerator
    {
        return $this->subject;
    }

    /**
     * @param RouteGenerator $subject
     *
     * @return RoutingEvent
     */
    public function setSubject(RouteGenerator $subject): RoutingEvent
    {
        $this->subject = $subject;

        return $this;
    }

}
