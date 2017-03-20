<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 13/03/2017
 * Time: 22:05
 */

namespace MjrOne\CodeGeneratorBundle\Services\Configuration;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class Router
 *
 * @package MjrOne\CodeGeneratorBundle\Services\Configuration
 */
class Router extends AbstractConfig
{
    /**
     * @var string
     */
    public $bundles;
    /**
     * @var string
     */
    public $development;

    /**
     * Router constructor.
     *
     * @param array $router
     */
    public function __construct(array $router)
    {
        $this->bundles = $router['bundles'];
        $this->development = $router['development'];
    }

    /**
     * @return string
     */
    public function getBundles(): string
    {
        return $this->bundles;
    }

    /**
     * @param string $bundles
     *
     * @return Router
     */
    public function setBundles(string $bundles): Router
    {
        $this->bundles = $bundles;

        return $this;
    }

    /**
     * @return string
     */
    public function getDevelopment(): string
    {
        return $this->development;
    }

    /**
     * @param string $development
     *
     * @return Router
     */
    public function setDevelopment(string $development): Router
    {
        $this->development = $development;

        return $this;
    }
    
    
}
