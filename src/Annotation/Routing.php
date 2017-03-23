<?php
declare(strict_types = 1);
/**
 * Created by Christopher Westerfield
 * copyright by Christopher Westerfield
 * Date: 07/01/2017
 * Time: 15:36
 */
namespace MjrOne\CodeGeneratorBundle\Annotation;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;
use MjrOne\CodeGeneratorBundle\Annotation\ClassInterface;
use MjrOne\CodeGeneratorBundle\Annotation\DriverInterface;
use MjrOne\CodeGeneratorBundle\Services\GeneratorService\Driver\RoutingGenerator;

/**
 * Class Router
 *
 * @package MjrOne\CodeGeneratorBundle\Annotation\ClassDefinition
 * @Annotation
 * @Target({"CLASS"})
 */
final class Routing extends AbstractAnnotation implements ClassInterface, DriverInterface
{
    const DRIVER = RoutingGenerator::class;

    const TYPE_ANNOTATION = 'annotation';
    const TYPE_YML = 'yml';
    const TYPE_XML = 'xml';
    const BUNDLE_PATH_YML = 'Resources/config/routing.yml';
    const BUNDLE_PATH_XML = 'Resources/config/routing.xml';
    const ALLOWED_TYPES = [
        self::TYPE_ANNOTATION,
        self::TYPE_YML,
        self::TYPE_XML,
    ];

    /**
     * @var bool
     */
    public $development = false;

    /**
     * @var bool
     */
    public $ignore=false;
    
    /**
     * @var string
     */
    public $type=self::TYPE_ANNOTATION;
    
    /**
     * @var string
     */
    public $prefix = '/';

    /**
     * @var string|null
     */
    public $resource;

    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $host;

    /**
     * @var string
     */
    public $controllerPath = 'Controller';

    /**
     * @return bool
     */
    public function getDevelopment()
    {
        return $this->development;
    }

    public function isDevelopment()
    {
        return $this->development;
    }

    /**
     * @param bool $development
     * @return Routing
     */
    public function setDevelopment(bool $development): Routing
    {
        $this->development = $development;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIgnore()
    {
        return $this->ignore;
    }

    public function isIgnore()
    {
        return $this->ignore;
    }

    /**
     * @param bool $ignore
     * @return Routing
     */
    public function setIgnore(bool $ignore): Routing
    {
        $this->ignore = $ignore;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Routing
     */
    public function setType(string $type): Routing
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return Routing
     */
    public function setPrefix(string $prefix): Routing
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param null|string $resource
     * @return Routing
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     * @return Routing
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getControllerPath()
    {
        return $this->controllerPath;
    }

    /**
     * @param string $controllerPath
     * @return Routing
     */
    public function setControllerPath(string $controllerPath): Routing
    {
        $this->controllerPath = $controllerPath;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param null|string $host
     * @return Routing
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }


}
