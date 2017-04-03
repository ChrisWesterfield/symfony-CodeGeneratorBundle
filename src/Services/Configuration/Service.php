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
 * Time: 22:15
 */

namespace MjrOne\CodeGeneratorBundle\Services\Configuration;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class Service
 *
 * @package MjrOne\CodeGeneratorBundle\Services\Configuration
 */
class Service extends AbstractConfig
{
    /**
     * @var string
     */
    public $class;
    /**
     * @var string
     */
    public $classShort;
    /**
     * @var string
     */
    public $service;

    /**
     * Service constructor.
     *
     * @param array $service
     */
    public function __construct(array $service)
    {
        $this->class = $service['class'];
        $this->service = $service['service'];
        if(empty($service['class_short']))
        {
            $refl = new \ReflectionClass($this->class);
            $this->classShort = $refl->getShortName();
        }
        else
        {
            $this->classShort = $service['class_short'];
        }
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return Service
     */
    public function setClass(string $class): Service
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return string
     */
    public function getClassShort(): string
    {
        return $this->classShort;
    }

    /**
     * @param string $classShort
     *
     * @return Service
     */
    public function setClassShort(string $classShort): Service
    {
        $this->classShort = $classShort;

        return $this;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @param string $service
     *
     * @return Service
     */
    public function setService(string $service): Service
    {
        $this->service = $service;

        return $this;
    }

}