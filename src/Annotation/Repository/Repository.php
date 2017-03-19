<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation\Repository;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;
use MjrOne\CodeGeneratorBundle\Annotation\ClassInterface;
use MjrOne\CodeGeneratorBundle\Annotation\DriverInterface;
use MjrOne\CodeGeneratorBundle\Services\Driver\RepositoryGenerator;

/**
 * Class Repository
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @package CodeGeneratorBundle\Annotation\ClassDefinition
 * @Annotation
 * @Target({"CLASS"})
 */
final class Repository extends AbstractAnnotation implements ClassInterface, DriverInterface
{
    const DRIVER = RepositoryGenerator::class;

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

    /**
     * @var string
     */
    public $using = '';

    /**
     * @var string
     */
    public $service = '';

    /**
     * @var string
     */
    public $entity;

    /**
     * @return bool
     */
    public function getSoftDelete()
    {
        return $this->softDelete;
    }

    public function isSoftDelete()
    {
        return $this->softDelete;
    }

    /**
     * @param bool $softDelete
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
    public function getPersist()
    {
        return $this->persist;
    }

    public function isPersist()
    {
        return $this->persist;
    }

    /**
     * @param bool $persist
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
    public function getTransaction()
    {
        return $this->transaction;
    }

    public function isTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param bool $transaction
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
    public function getRemove()
    {
        return $this->remove;
    }

    public function isRemove()
    {
        return $this->remove;
    }

    /**
     * @param bool $remove
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
    public function getResults()
    {
        return $this->results;
    }

    public function isResults()
    {
        return $this->results;
    }

    /**
     * @param bool $results
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
    public function getResult()
    {
        return $this->result;
    }

    public function isResult()
    {
        return $this->result;
    }

    /**
     * @param bool $result
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
    public function getEm()
    {
        return $this->em;
    }

    public function isEm()
    {
        return $this->em;
    }

    /**
     * @param bool $em
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
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    public function isQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @param bool $queryBuilder
     * @return Repository
     */
    public function setQueryBuilder(bool $queryBuilder): Repository
    {
        $this->queryBuilder = $queryBuilder;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsing()
    {
        return $this->using;
    }

    /**
     * @param string $using
     * @return Repository
     */
    public function setUsing(string $using): Repository
    {
        $this->using = $using;
        return $this;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return Repository
     */
    public function setService(string $service): Repository
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     * @return Repository
     */
    public function setEntity(string $entity): Repository
    {
        $this->entity = $entity;
        return $this;
    }
}
