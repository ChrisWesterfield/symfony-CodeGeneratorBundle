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
 * Time: 22:08
 */

namespace MjrOne\CodeGeneratorBundle\Services\Configuration;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class User
 *
 * @package MjrOne\CodeGeneratorBundle\Services\Configuration
 */
class User extends AbstractConfig
{
    /**
     * @var string
     */
    public $factoryClass;
    /**
     * @var string
     */
    public $shortFactoryClass;
    /**
     * @var string
     */
    public $factoryService;
    /**
     * @var string
     */
    public $repositoryService;
    /**
     * @var string
     */
    public $entity;
    /**
     * @var string
     */
    public $entityShort;

    /**
     * @var bool
     */
    public $enabled;

    public function __construct(array $user)
    {
        if($user['enabled'])
        {
            $this->enabled = true;
            $this->factoryClass = $user['factory_class'];
            $this->factoryService = $user['factory_service'];
            $this->repositoryService = $user['repository_service'];
            $this->entity = $user['entity'];
            if (empty($user['factory_class_short']))
            {
                $reflection = new \ReflectionClass($this->factoryClass);
                $this->shortFactoryClass = $reflection->getShortName();
            }
            else
            {
                $this->shortFactoryClass = $user['factory_class_short'];
            }
            if (empty($user['entity_short']))
            {
                $reflection = new \ReflectionClass($this->entity);
                $this->entityShort = $reflection->getShortName();
            }
            else
            {
                $this->entityShort = $user['entity_short'];
            }
        }
        else
        {
            $this->enabled = false;
        }
    }

    /**
     * @return string
     */
    public function getFactoryClass(): string
    {
        return $this->factoryClass;
    }

    /**
     * @param string $factoryClass
     *
     * @return User
     */
    public function setFactoryClass(string $factoryClass): User
    {
        $this->factoryClass = $factoryClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortFactoryClass(): string
    {
        return $this->shortFactoryClass;
    }

    /**
     * @param string $shortFactoryClass
     *
     * @return User
     */
    public function setShortFactoryClass(string $shortFactoryClass): User
    {
        $this->shortFactoryClass = $shortFactoryClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getFactoryService(): string
    {
        return $this->factoryService;
    }

    /**
     * @param string $factoryService
     *
     * @return User
     */
    public function setFactoryService(string $factoryService): User
    {
        $this->factoryService = $factoryService;

        return $this;
    }

    /**
     * @return string
     */
    public function getRepositoryService(): string
    {
        return $this->repositoryService;
    }

    /**
     * @param string $repositoryService
     *
     * @return User
     */
    public function setRepositoryService(string $repositoryService): User
    {
        $this->repositoryService = $repositoryService;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     *
     * @return User
     */
    public function setEntity(string $entity): User
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityShort(): string
    {
        return $this->entityShort;
    }

    /**
     * @param string $entityShort
     *
     * @return User
     */
    public function setEntityShort(string $entityShort): User
    {
        $this->entityShort = $entityShort;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return User
     */
    public function setEnabled(bool $enabled): User
    {
        $this->enabled = $enabled;

        return $this;
    }


}
