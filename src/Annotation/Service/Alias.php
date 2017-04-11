<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation\Service;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;
use MjrOne\CodeGeneratorBundle\Annotation\ClassInterface;
use MjrOne\CodeGeneratorBundle\Annotation\SubDriverInterface;
use MjrOne\CodeGeneratorBundle\Generator\Service\ServiceAliasGenerator;

/**
 * Class Alias
 * @author    Chris Westerfield <chris@mjr.one>
 * @package CodeGeneratorBundle\Annotation\Service
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @package codegenerator\Annotation
 * @Annotation
 * @Target({"CLASS"})
 */
final class Alias extends AbstractAnnotation implements ClassInterface, ServiceInterface, SubDriverInterface
{
    const DRIVER = ServiceAliasGenerator::class;
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $alias;

    /**
     * @var bool|null
     */
    public $publicService;

    /**
     * @var bool
     */
    public $depricated = false;

    /**
     * @var string
     */
    public $depricatedMessage;

    /**
     * @return bool|null
     */
    public function getPublicService()
    {
        return $this->publicService;
    }

    /**
     * @param bool|null $publicService
     *
     * @return Alias
     */
    public function setPublicService($publicService)
    {
        $this->publicService = $publicService;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDepricated(): bool
    {
        return $this->depricated;
    }

    /**
     * @param bool $depricated
     *
     * @return Alias
     */
    public function setDepricated(bool $depricated): Alias
    {
        $this->depricated = $depricated;

        return $this;
    }

    /**
     * @return string
     */
    public function getDepricatedMessage(): string
    {
        return $this->depricatedMessage;
    }

    /**
     * @param string $depricatedMessage
     *
     * @return Alias
     */
    public function setDepricatedMessage(string $depricatedMessage): Alias
    {
        $this->depricatedMessage = $depricatedMessage;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Alias
     */
    public function setName(string $name): Alias
    {
        $this->name = $name;
        return $this;
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
     * @return Alias
     */
    public function setAlias(string $alias): Alias
    {
        $this->alias = $alias;
        return $this;
    }
}
