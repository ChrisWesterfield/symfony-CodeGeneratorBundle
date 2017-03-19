<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 13/03/2017
 * Time: 22:04
 */

namespace MjrOne\CodeGeneratorBundle\Services;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\ConfigurationEvent;
use MjrOne\CodeGeneratorBundle\Services\Configuration\AbstractConfig;
use MjrOne\CodeGeneratorBundle\Services\Configuration\Core;
use MjrOne\CodeGeneratorBundle\Services\Configuration\FileProperties;
use MjrOne\CodeGeneratorBundle\Services\Configuration\Router;
use MjrOne\CodeGeneratorBundle\Services\Configuration\Service;
use MjrOne\CodeGeneratorBundle\Services\Configuration\User;

class ConfigurationService extends AbstractConfig
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
        $this->ed->dispatch($this->ed->getEventName(self::class,'prepare'),$event);
        $config = $event->getConfig();
        $this->router = new Router($config['router']);
        $this->ed->dispatch($this->ed->getEventName(self::class,'setRouter'),$event);
        $this->entityInterfaceClass = $config['entity_interface_class'];
        $this->ed->dispatch($this->ed->getEventName(self::class,'setEntityInterface'),$event);
        $this->user = new User($config['user']);
        $this->ed->dispatch($this->ed->getEventName(self::class,'setUser'),$event);
        $this->cache = new Service($config['cache']);
        $this->ed->dispatch($this->ed->getEventName(self::class,'setCache'),$event);
        $this->event = new Service($config['event']);
        $this->ed->dispatch($this->ed->getEventName(self::class,'setEvent'),$event);
        $this->fileProperties = new FileProperties($config['file_properties']);
        $this->ed->dispatch($this->ed->getEventName(self::class,'setFileProperties'),$event);
        $this->core = new Core($config['core']);
        $this->ed->dispatch($this->ed->getEventName(self::class,'setCore'),$event);
        $this->ed->dispatch($this->ed->getEventName(self::class,'finished'),$event);
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
     * @return ConfigurationService
     */
    public function setRouter(Router $router): ConfigurationService
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
     * @return ConfigurationService
     */
    public function setEntityInterfaceClass(string $entityInterfaceClass): ConfigurationService
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
     * @return ConfigurationService
     */
    public function setUser(User $user): ConfigurationService
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
     * @return ConfigurationService
     */
    public function setCache(Service $cache): ConfigurationService
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
     * @return ConfigurationService
     */
    public function setEvent(Service $event): ConfigurationService
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
     * @return ConfigurationService
     */
    public function setFileProperties(FileProperties $fileProperties
    ): ConfigurationService
    {
        $this->fileProperties = $fileProperties;

        return $this;
    }

    /**
     * @return \MjrOne\CodeGeneratorBundle\Services\Configuration\Core
     */
    public function getCore(): \MjrOne\CodeGeneratorBundle\Services\Configuration\Core
    {
        return $this->core;
    }

    /**
     * @return \MjrOne\CodeGeneratorBundle\Services\EventDispatcherService
     */
    public function getEd(): \MjrOne\CodeGeneratorBundle\Services\EventDispatcherService
    {
        return $this->ed;
    }
}
