<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation\Entity;
use MJR\CodeGeneratorBundle\Annotation\AbstractDefinition;


/**
 * Class Entity
 * @package MjrOne\CodeGeneratorBundle\Annotation\Mutator
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"CLASS"})
 */
final class Entity extends AbstractDefinition
{
    /**
     * @var string
     */
    public $repository;

    /**
     * @var bool
     */
    public $addEntityAnnotation=false;

    /**
     * @var string
     */
    public $targetNameSpace;

    /**
     * @var string
     */
    public $targetDirectory;

    /**
     * @var string
     */
    public $targetRepositoryClassName;

    /**
     * @var string
     */
    public $extendsClass = 'Doctrine\ORM\EntityRepository';

    /**
     * @var string
     */
    public $extendsShort = 'EntityRepository';

    /**
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param string $repository
     * @return Entity
     */
    public function setRepository(string $repository): Entity
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return bool
     */
    public function getAddEntityAnnotation()
    {
        return $this->addEntityAnnotation;
    }

    public function isAddEntityAnnotation()
    {
        return $this->addEntityAnnotation;
    }

    /**
     * @param bool $addEntityAnnotation
     * @return Entity
     */
    public function setAddEntityAnnotation(bool $addEntityAnnotation): Entity
    {
        $this->addEntityAnnotation = $addEntityAnnotation;
        return $this;
    }

    /**
     * @return string
     */
    public function getTargetNameSpace()
    {
        return $this->targetNameSpace;
    }

    /**
     * @param string $targetNameSpace
     * @return Entity
     */
    public function setTargetNameSpace(string $targetNameSpace): Entity
    {
        $this->targetNameSpace = $targetNameSpace;
        return $this;
    }

    /**
     * @return string
     */
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    /**
     * @param string $targetDirectory
     * @return Entity
     */
    public function setTargetDirectory(string $targetDirectory): Entity
    {
        $this->targetDirectory = $targetDirectory;
        return $this;
    }

    /**
     * @return string
     */
    public function getTargetRepositoryClassName()
    {
        return $this->targetRepositoryClassName;
    }

    /**
     * @param string $targetRepositoryClassName
     * @return Entity
     */
    public function setTargetRepositoryClassName(string $targetRepositoryClassName): Entity
    {
        $this->targetRepositoryClassName = $targetRepositoryClassName;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtendsClass()
    {
        return $this->extendsClass;
    }

    /**
     * @param string $extendsClass
     * @return Entity
     */
    public function setExtendsClass(string $extendsClass): Entity
    {
        $this->extendsClass = $extendsClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtendsShort()
    {
        return $this->extendsShort;
    }

    /**
     * @param string $extendsShort
     * @return Entity
     */
    public function setExtendsShort(string $extendsShort): Entity
    {
        $this->extendsShort = $extendsShort;
        return $this;
    }


}
