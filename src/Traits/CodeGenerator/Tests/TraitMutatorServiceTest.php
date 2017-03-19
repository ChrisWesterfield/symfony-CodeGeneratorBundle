<?php
declare(strict_types = 1); /**
 * Automatically created file
 * Changes will be overwritten on AutoGenerator Run!
 */
 namespace MjrOne\CodeGeneratorBundle\Traits\CodeGenerator\Tests;
use MjrOne\CodeGeneratorBundle\Tests\ServiceTest;

/**
 * TraitMutatorServiceTest
 * @author    Christopher Westerfield <chris.westerfield@spectware.com>
 * @package   MjrOne\CodeGeneratorBundle\Traits\CodeGenerator\Tests
 * @link      https://www.spectware.com
 * @copyright copyright (c) by Spectware, Inc.
 * @license   SpectwarePro Source License
 * @property bool $test
 * @property \MjrOne\CodeGeneratorBundle\Services\RenderService $test2
 * @property string $test3
 * @property \MjrOne\CodeGeneratorBundle\MjrOneCodeGeneratorBundle $test4
 * @property array $test5
 * @property \Doctrine\Common\Collections\ArrayCollection $test6
 * @property \Doctrine\Common\Collections\ArrayCollection $test7
 * @property string[] $test8
 * @property string[] $test9
 * @property \Twig_Environment $twig
 * @property \Symfony\Bundle\FrameworkBundle\Routing\Router $router
 * @property \MjrOne\CodeGeneratorBundle\Tests\CacheService $cache
 * @property \Symfony\Component\EventDispatcher\EventDispatcherInterface $event
 * @property \MjrOne\CodeGeneratorBundle\Tests\EntityManager $entityManager
 * Generatored by MJR.ONE CodeGenerator Bundle (Generator Copyright (c) by Chris Westerfield 2017, Licensed under LGPL V3) - Version 1.0.0
 * Last Update: 19.03.2017 - 23:24:48
 */

trait TraitMutatorServiceTest
{
    /**
     * isTest
     * @return bool
     */
    protected function isTest(): bool    {
        return $this->test;
    }

    /**
     * setTest
     * @param bool $value
     *
     * @return ServiceTest
     */
    protected function setTest(bool $value):ServiceTest
    {
        $this->test = $value;
        return $this;
    }

    /**
     * hasTest
     * 
     *
     * @return bool
     */
    protected function hasTest(): bool    {
        return !empty($this->test);
    }

    /**
     * getTest2
     * @return \MjrOne\CodeGeneratorBundle\Services\RenderService
     */
    protected function getTest2(): \MjrOne\CodeGeneratorBundle\Services\RenderService    {
        return $this->test2;
    }

    /**
     * setTest2
     * @param \MjrOne\CodeGeneratorBundle\Services\RenderService $value
     *
     * @return ServiceTest
     */
    protected function setTest2(\MjrOne\CodeGeneratorBundle\Services\RenderService $value):ServiceTest
    {
        $this->test2 = $value;
        return $this;
    }

    /**
     * hasTest2
     * 
     *
     * @return bool
     */
    protected function hasTest2(): bool    {
        return !empty($this->test2);
    }

    /**
     * getTest3
     * @return string
     */
    protected function getTest3(): string    {
        return $this->test3;
    }

    /**
     * setTest3
     * @param string $value
     *
     * @return ServiceTest
     */
    protected function setTest3(string $value):ServiceTest
    {
        $this->test3 = $value;
        return $this;
    }

    /**
     * hasTest3
     * 
     *
     * @return bool
     */
    protected function hasTest3(): bool    {
        return !empty($this->test3);
    }

    /**
     * getTest4
     * @return \MjrOne\CodeGeneratorBundle\MjrOneCodeGeneratorBundle
     */
    protected function getTest4(): \MjrOne\CodeGeneratorBundle\MjrOneCodeGeneratorBundle    {
        return $this->test4;
    }

    /**
     * setTest4
     * @param \MjrOne\CodeGeneratorBundle\MjrOneCodeGeneratorBundle $value
     *
     * @return ServiceTest
     */
    protected function setTest4(\MjrOne\CodeGeneratorBundle\MjrOneCodeGeneratorBundle $value):ServiceTest
    {
        $this->test4 = $value;
        return $this;
    }

    /**
     * hasTest4
     * 
     *
     * @return bool
     */
    protected function hasTest4(): bool    {
        return !empty($this->test4);
    }

    /**
     * getTest5
     * @return array
     */
    protected function getTest5(): array    {
        return $this->test5;
    }

    /**
     * setTest5
     * @param array $value
     *
     * @return ServiceTest
     */
    protected function setTest5(array $value):ServiceTest
    {
        $this->test5 = $value;
        return $this;
    }

    /**
     * hasTest5
     *  @param   $check
     * 
     *
     * @return bool
     */
    protected function hasTest5(  $value): bool    {
        return in_array($value,$this->test5,true);
    }

    /**
     * addTest5
     * @param  $value
     *
     * @return ServiceTest
     */
    protected function addTest5( $value):ServiceTest    {
        if(!$this->hasTest5($value))
        {
            $this->test5[] = $value;
        }

        return $this;
    }

    /**
     * removeTest5
     * @param array  $value
     *
     * @return ServiceTest
     */
    protected function removeTest5( $value):ServiceTest    {
        if($this->hasTest5($value))
        {
            if(($key = array_search($value, $this->test5)) !== false) {
              unset($this->test5[$key]);
            }

        }

        return $this;
    }

    /**
     * countTest5
     * @return int
     */
    protected function countTest5(): int    {
        return count($this->test5);
    }

    /**
     * getTest6
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    protected function getTest6(): \Doctrine\Common\Collections\ArrayCollection    {
        return $this->test6;
    }

    /**
     * setTest6
     * @param \Doctrine\Common\Collections\ArrayCollection $value
     *
     * @return ServiceTest
     */
    protected function setTest6(\Doctrine\Common\Collections\ArrayCollection $value):ServiceTest
    {
        $this->test6 = $value;
        return $this;
    }

    /**
     * hasTest6
     *  @param   $check
     * 
     *
     * @return bool
     */
    protected function hasTest6(  $value): bool    {
        return $this->test6->contains($value);
    }

    /**
     * addTest6
     * @param  $value
     *
     * @return ServiceTest
     */
    protected function addTest6( $value):ServiceTest    {
        if(!$this->hasTest6($value))
        {
            $this->test6->add($value);
        }

        return $this;
    }

    /**
     * removeTest6
     * @param \Doctrine\Common\Collections\ArrayCollection  $value
     *
     * @return ServiceTest
     */
    protected function removeTest6( $value):ServiceTest    {
        if($this->hasTest6($value))
        {
            $this->test6->removeElement($value);
        }

        return $this;
    }

    /**
     * countTest6
     * @return int
     */
    protected function countTest6(): int    {
        return $this->test6->count();
    }

    /**
     * getTest7
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    protected function getTest7(): \Doctrine\Common\Collections\ArrayCollection    {
        return $this->test7;
    }

    /**
     * setTest7
     * @param \Doctrine\Common\Collections\ArrayCollection $value
     *
     * @return ServiceTest
     */
    protected function setTest7(\Doctrine\Common\Collections\ArrayCollection $value):ServiceTest
    {
        $this->test7 = $value;
        return $this;
    }

    /**
     * hasTest7
     *  @param   $check
     * 
     *
     * @return bool
     */
    protected function hasTest7(  $value): bool    {
        return $this->test7->contains($value);
    }

    /**
     * addTest7
     * @param  $value
     *
     * @return ServiceTest
     */
    protected function addTest7( $value):ServiceTest    {
        if(!$this->hasTest7($value))
        {
            $this->test7->add($value);
        }

        return $this;
    }

    /**
     * removeTest7
     * @param \Doctrine\Common\Collections\ArrayCollection  $value
     *
     * @return ServiceTest
     */
    protected function removeTest7( $value):ServiceTest    {
        if($this->hasTest7($value))
        {
            $this->test7->removeElement($value);
        }

        return $this;
    }

    /**
     * countTest7
     * @return int
     */
    protected function countTest7(): int    {
        return $this->test7->count();
    }

    /**
     * getTest8
     * @return string[]
     */
    protected function getTest8(): array    {
        return $this->test8;
    }

    /**
     * setTest8
     * @param array $value
     *
     * @return ServiceTest
     */
    protected function setTest8(array $value):ServiceTest
    {
        $this->test8 = $value;
        return $this;
    }

    /**
     * hasTest8
     *  @param string  $check
     * 
     *
     * @return bool
     */
    protected function hasTest8(string  $value): bool    {
        return in_array($value,$this->test8,true);
    }

    /**
     * addTest8
     * @param string $value
     *
     * @return ServiceTest
     */
    protected function addTest8(string $value):ServiceTest    {
        if(!$this->hasTest8($value))
        {
            $this->test8[] = $value;
        }

        return $this;
    }

    /**
     * removeTest8
     * @param string $value
     *
     * @return ServiceTest
     */
    protected function removeTest8(string $value):ServiceTest    {
        if($this->hasTest8($value))
        {
            if(($key = array_search($value, $this->test8)) !== false) {
              unset($this->test8[$key]);
            }

        }

        return $this;
    }

    /**
     * countTest8
     * @return int
     */
    protected function countTest8(): int    {
        return count($this->test8);
    }



    /**
     * hasTest9
     *  @param string  $check
     * 
     *
     * @return bool
     */
    public function hasTest9(string  $value): bool    {
        return in_array($value,$this->test9,true);
    }

    /**
     * addTest9
     * @param string $value
     *
     * @return ServiceTest
     */
    public function addTest9(string $value):ServiceTest    {
        if(!$this->hasTest9($value))
        {
            $this->test9[] = $value;
        }

        return $this;
    }

    /**
     * removeTest9
     * @param string $value
     *
     * @return ServiceTest
     */
    public function removeTest9(string $value):ServiceTest    {
        if($this->hasTest9($value))
        {
            if(($key = array_search($value, $this->test9)) !== false) {
              unset($this->test9[$key]);
            }

        }

        return $this;
    }

    /**
     * countTest9
     * @return int
     */
    public function countTest9(): int    {
        return count($this->test9);
    }

}
