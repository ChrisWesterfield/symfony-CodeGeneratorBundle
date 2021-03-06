<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;
use MjrOne\CodeGeneratorBundle\Annotation\ClassInterface;
use MjrOne\CodeGeneratorBundle\Annotation\DriverInterface;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorRepository;

/**
 * Class Repository
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @package CodeGeneratorBundle\Annotation\ClassDefinition
 * @author    Chris Westerfield <chris@mjr.one>
 * @Annotation
 * @Target({"CLASS"})
 */
final class Repository extends AbstractAnnotation implements ClassInterface, DriverInterface
{
    const DRIVER = CodeGeneratorRepository::class;

    /**
     * @var bool
     */
    public $softDelete =true;

    /**
     * @var bool
     */
    public $persist = true;

    /**
     * @var bool
     */
    public $transaction = true;

    /**
     * @var bool
     */
    public $remove = true;

    /**
     * @var bool
     */
    public $results = true;

    /**
     * @var bool
     */
    public $result = true;

    /**
     * @var bool
     */
    public $em = true;

    /**
     * @var bool
     */
    public $queryBuilder = true;

    /***
     * @var bool
     */
    public $flush = true;

    /**
     * @var string
     */
    public $entity;

    /**
     * @var string
     */
    public $serviceName;

    /**
     * @return bool
     */
    public function isSoftDelete(): bool
    {
        return $this->softDelete;
    }

    /**
     * @param bool $softDelete
     *
     * @return Repository
     */
    public function setSoftDelete(bool $softDelete): Repository
    {
        $this->softDelete = $softDelete;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPersist(): bool
    {
        return $this->persist;
    }

    /**
     * @param bool $persist
     *
     * @return Repository
     */
    public function setPersist(bool $persist): Repository
    {
        $this->persist = $persist;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTransaction(): bool
    {
        return $this->transaction;
    }

    /**
     * @param bool $transaction
     *
     * @return Repository
     */
    public function setTransaction(bool $transaction): Repository
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRemove(): bool
    {
        return $this->remove;
    }

    /**
     * @param bool $remove
     *
     * @return Repository
     */
    public function setRemove(bool $remove): Repository
    {
        $this->remove = $remove;

        return $this;
    }

    /**
     * @return bool
     */
    public function isResults(): bool
    {
        return $this->results;
    }

    /**
     * @param bool $results
     *
     * @return Repository
     */
    public function setResults(bool $results): Repository
    {
        $this->results = $results;

        return $this;
    }

    /**
     * @return bool
     */
    public function isResult(): bool
    {
        return $this->result;
    }

    /**
     * @param bool $result
     *
     * @return Repository
     */
    public function setResult(bool $result): Repository
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEm(): bool
    {
        return $this->em;
    }

    /**
     * @param bool $em
     *
     * @return Repository
     */
    public function setEm(bool $em): Repository
    {
        $this->em = $em;

        return $this;
    }

    /**
     * @return bool
     */
    public function isQueryBuilder(): bool
    {
        return $this->queryBuilder;
    }

    /**
     * @param bool $queryBuilder
     *
     * @return Repository
     */
    public function setQueryBuilder(bool $queryBuilder): Repository
    {
        $this->queryBuilder = $queryBuilder;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFlush(): bool
    {
        return $this->flush;
    }

    /**
     * @param bool $flush
     *
     * @return Repository
     */
    public function setFlush(bool $flush): Repository
    {
        $this->flush = $flush;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param null|string $entity
     *
     * @return Repository
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @param null|string $serviceName
     *
     * @return Repository
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;

        return $this;
    }
}
