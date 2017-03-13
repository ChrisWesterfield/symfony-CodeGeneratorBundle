<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation\Service;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;

/**
 * Service
 * Defines the master Properties for Services
 * @package CodeGeneratorBundle\Annotation\Service
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS"})
 */
final class Service extends AbstractAnnotation
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var bool
     */
    public $publicService = true;

    /**
     * @var string
     */
    public $alias;

    /**
     * @var bool
     */
    public $depricated = false;

    /**
     * @var mixed
     */
    public $scope;

    /**
     * @var string
     */
    public $depricatedMessage = '';

    /**
     * @var bool
     */
    public $controller = false;

    /**
     * @var bool
     */
    public $lazy = false;

    /**
     * @var string
     */
    public $constructorMethods = '';

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function getPublicService()
    {
        return $this->publicService;
    }

    public function isPublicService()
    {
        return $this->publicService;
    }

    /**
     * @param bool $publicService
     */
    public function setPublicService($publicService)
    {
        $this->publicService = $publicService;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return bool
     */
    public function getDepricated()
    {
        return $this->depricated;
    }

    public function isDepricated()
    {
        return $this->depricated;
    }

    /**
     * @param bool $depricated
     */
    public function setDepricated($depricated)
    {
        $this->depricated = $depricated;
    }

    /**
     * @return mixed
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param mixed $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return string
     */
    public function getDepricatedMessage()
    {
        return $this->depricatedMessage;
    }

    /**
     * @param string $depricatedMessage
     */
    public function setDepricatedMessage($depricatedMessage)
    {
        $this->depricatedMessage = $depricatedMessage;
    }

    /**
     * @return bool
     */
    public function getController()
    {
        return $this->controller;
    }

    public function isController()
    {
        return $this->controller;
    }

    /**
     * @param bool $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return bool
     */
    public function getLazy()
    {
        return $this->lazy;
    }

    public function isLazy()
    {
        return $this->lazy;
    }

    /**
     * @param bool $lazy
     */
    public function setLazy($lazy)
    {
        $this->lazy = $lazy;
    }

    /**
     * @return string
     */
    public function getConstructorMethods()
    {
        return $this->constructorMethods;
    }

    /**
     * @param string $constructorMethods
     */
    public function setConstructorMethods($constructorMethods)
    {
        $this->constructorMethods = $constructorMethods;
    }


}
