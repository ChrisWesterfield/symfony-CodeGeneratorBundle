<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;

/**
 * Class Entity
 *
 * @package MjrOne\CodeGeneratorBundle\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Entity
{
    /**
     * @var string
     */
    private $entityPath;

    /**
     * @var string
     */
    private $repositoryPath;

    /**
     * @var string
     */
    private $mappingPath;

    /**
     * @param string $entityPath
     * @param string $repositoryPath
     * @param string $mappingPath
     */
    public function __construct($entityPath, $repositoryPath, $mappingPath)
    {
        $this->entityPath = $entityPath;
        $this->repositoryPath = $repositoryPath;
        $this->mappingPath = $mappingPath;
    }

    /**
     * @return string
     */
    public function getEntityPath():string
    {
        return $this->entityPath;
    }

    /**
     * @return string
     */
    public function getRepositoryPath():string
    {
        return $this->repositoryPath;
    }

    /**
     * @return string|null
     */
    public function getMappingPath()
    {
        return $this->mappingPath;
    }
}
