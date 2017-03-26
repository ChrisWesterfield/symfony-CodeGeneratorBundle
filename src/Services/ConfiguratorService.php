<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Services;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\ConfigurationEvent;
use MjrOne\CodeGeneratorBundle\Configuration\AbstractConfig;
use MjrOne\CodeGeneratorBundle\Configuration\Core;
use MjrOne\CodeGeneratorBundle\Configuration\FileProperties;
use MjrOne\CodeGeneratorBundle\Configuration\Router;
use MjrOne\CodeGeneratorBundle\Configuration\Service;
use MjrOne\CodeGeneratorBundle\Configuration\User;

/**
 * Class ConfiguratorService
 *
 * @package   MjrOne\CodeGeneratorBundle\Services
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class ConfiguratorService extends AbstractConfig
{
    /**
     * @var Router
     */
    public $router;
    /**
     * @var string
     */
    public $entityInterfaceClass;

    /**
     * @var User
     */
    public $user;
    /**
     * @var Service
     */
    public $cache;
    /**
     * @var Service
     */
    public $event;

    /**
     * @var FileProperties
     */
    public $fileProperties;

    /**
     * @var Core
     */
    public $core;

    /**
     * @var EventDispatcherService
     */
    protected $ed;

    /**
     * ConfigurationService constructor.
     *
     * @param array $config
     */
    public function __construct(array $config, EventDispatcherService $service)
    {
        $this->ed = $service;
        $event = (new ConfigurationEvent())->setSubject($this)->setConfig($config);
        $this->ed->dispatch($this->ed->getEventName(self::class, 'prepare'), $event);
        $config = $event->getConfig();
        $this->router = new Router($config['router']);
        $this->ed->dispatch($this->ed->getEventName(self::class, 'setRouter'), $event);
        $this->entityInterfaceClass = $config['entity_interface_class'];
        $this->ed->dispatch($this->ed->getEventName(self::class, 'setEntityInterface'), $event);
        $this->user = new User($config['user']);
        $this->ed->dispatch($this->ed->getEventName(self::class, 'setUser'), $event);
        $this->cache = new Service($config['cache']);
        $this->ed->dispatch($this->ed->getEventName(self::class, 'setCache'), $event);
        $this->event = new Service($config['event']);
        $this->ed->dispatch($this->ed->getEventName(self::class, 'setEvent'), $event);
        $this->fileProperties = new FileProperties($config['file_properties']);
        $this->ed->dispatch($this->ed->getEventName(self::class, 'setFileProperties'), $event);
        $this->core = new Core($config['core']);
        $this->ed->dispatch($this->ed->getEventName(self::class, 'setCore'), $event);
        $this->ed->dispatch($this->ed->getEventName(self::class, 'finished'), $event);
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * @param Router $router
     *
     * @return ConfiguratorService
     */
    public function setRouter(Router $router): ConfiguratorService
    {
        $this->router = $router;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityInterfaceClass(): string
    {
        return $this->entityInterfaceClass;
    }

    /**
     * @param string $entityInterfaceClass
     *
     * @return ConfiguratorService
     */
    public function setEntityInterfaceClass(string $entityInterfaceClass): ConfiguratorService
    {
        $this->entityInterfaceClass = $entityInterfaceClass;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return ConfiguratorService
     */
    public function setUser(User $user): ConfiguratorService
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Service
     */
    public function getCache(): Service
    {
        return $this->cache;
    }

    /**
     * @param Service $cache
     *
     * @return ConfiguratorService
     */
    public function setCache(Service $cache): ConfiguratorService
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return Service
     */
    public function getEvent(): Service
    {
        return $this->event;
    }

    /**
     * @param Service $event
     *
     * @return ConfiguratorService
     */
    public function setEvent(Service $event): ConfiguratorService
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return FileProperties
     */
    public function getFileProperties(): FileProperties
    {
        return $this->fileProperties;
    }

    /**
     * @param FileProperties $fileProperties
     *
     * @return ConfiguratorService
     */
    public function setFileProperties(FileProperties $fileProperties
    ): ConfiguratorService
    {
        $this->fileProperties = $fileProperties;

        return $this;
    }

    /**
     * @return Core
     */
    public function getCore(): Core
    {
        return $this->core;
    }

    /**
     * @return EventDispatcherService
     */
    public function getEd(): EventDispatcherService
    {
        return $this->ed;
    }
}
