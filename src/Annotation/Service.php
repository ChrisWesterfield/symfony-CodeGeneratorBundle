<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;
use MjrOne\CodeGeneratorBundle\Annotation\ClassInterface;
use MjrOne\CodeGeneratorBundle\Annotation\DriverInterface;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorService;

/**
 * Service
 * Defines the master Properties for Services
 * @package CodeGeneratorBundle\Annotation\Service
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS"})
 */
final class Service extends AbstractAnnotation implements ClassInterface, DriverInterface
{
    const DRIVER = CodeGeneratorService::class;
    /**
     * Name of the Service
     * @var string
     */
    public $name;

    /**
     * Is this a public Service
     * @var bool
     */
    public $publicService = true;

    /**
     * Is this Service depricated
     * @var bool
     */
    public $depricated = false;

    /**
     * Scope of Service
     * @var mixed
     */
    public $scope;

    /**
     * depricated Message
     * @var string
     */
    public $depricatedMessage = '';

    /**
     * Is this Service an Controller
     * @var bool
     */
    public $controller = false;

    /**
     * Use Lazy Loading
     * @var bool
     */
    public $lazy = false;

    /**
     * Methods called in constructors (example: init($variables), ...
     * insert $variables to add a parameter that is added either as part of an injected service etc
     * @var array<\MjrOne\CodeGeneratorBundle\Annotation\Service\Construction>
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
     * @return array
     */
    public function getConstructorMethods()
    {
        return $this->constructorMethods;
    }

    /**
     * @param array $constructorMethods
     */
    public function setConstructorMethods(array $constructorMethods)
    {
        $this->constructorMethods = $constructorMethods;
    }


}
