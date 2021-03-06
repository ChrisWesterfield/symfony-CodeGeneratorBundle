<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Configuration;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class Route
 *
 * @package MjrOne\CodeGeneratorBundle\Configuration
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Route extends AbstractConfig
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $resource;

    /**
     * @var string
     */
    public $prefix;

    /**
     * @var string
     */
    public $host;

    /**
     * @var string
     */
    public $type;

    public function __construct($route)
    {
        $this->name = $route['name'];
        $this->resource = $route['resource'];
        if(array_key_exists('prefix',$route))
        {
           $this->prefix = $route['prefix'];
        }
        if(array_key_exists('host', $route))
        {
            $this->host = $route['host'];
        }
        if(array_key_exists('type', $route))
        {
            $this->type = $route['type'];
        }
        else
        {
            $this->type = CG\Routing::TYPE_ANNOTATION;
        }
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }
}
