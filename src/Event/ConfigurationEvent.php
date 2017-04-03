<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\ConfiguratorService;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ConfigurationEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class ConfigurationEvent extends Event
{
    /**
     * @var ConfiguratorService
     */
    protected $subject;

    /**
     * @var array
     */
    protected $config;

    /**
     * @return ConfiguratorService
     */
    public function getSubject(): ConfiguratorService
    {
        return $this->subject;
    }

    /**
     * @param ConfiguratorService $subject
     *
     * @return ConfigurationEvent
     */
    public function setSubject(ConfiguratorService $subject): ConfigurationEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     *
     * @return ConfigurationEvent
     */
    public function setConfig(array $config): ConfigurationEvent
    {
        $this->config = $config;

        return $this;
    }
}
