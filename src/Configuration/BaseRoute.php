<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Configuration;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class BaseRoute
 *
 * @package   MjrOne\CodeGeneratorBundle\Configuration
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class BaseRoute extends AbstractConfig
{
    /**
     * @var Route[]
     */
    public $production;

    /**
     * @var Route[]
     */
    public $development;

    /**
     * BaseRoute constructor.
     *
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->production = [];
        $this->development = [];
        foreach ($routes as $id => $route)
        {
            if (!empty($route))
            {
                foreach ($route as $entity)
                {
                    $this->{$id}[] = new Route($entity);
                }
            }
        }
    }

    /**
     * @return Route[]
     */
    public function getProduction(): array
    {
        return $this->production;
    }

    /**
     * @return Route[]
     */
    public function getDevelopment(): array
    {
        return $this->development;
    }

    /**
     * @return array
     */
    public function getProductionRouteArray()
    {
        $return = [];
        if (!empty($this->production))
        {
            foreach ($this->production as $route)
            {
                $return[] = $route->toArray();
            }
        }

        return $return;
    }

    /**
     * @return array
     */
    public function getDevelopmentRouteArray()
    {
        $return = [];
        if (!empty($this->development))
        {
            foreach ($this->development as $route)
            {
                $return[] = $route->toArray();
            }
        }

        return $return;
    }
}
