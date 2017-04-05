<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class CodeGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class File Extends DocumentAbstract
{
    /**
     * @var bool
     */
    protected $strict=false;

    /**
     * @var  string
     */
    protected $classComment;

    /**
     * @var string
     */
    protected $className;

    /**
     * @var string
     */
    protected $extends;

    /**
     * @var array
     */
    protected $interfaces;

    /**
     * @var Method[]
     */
    protected $methods;

    /**
     * @var Property[]
     */
    protected $properties;

    /**
     * @var Property[]
     */
    protected $constants;

    /**
     * @var bool
     */
    protected $noFileExists=false;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var array
     */
    protected $usedNamespaces;

    /**
     * @var bool
     */
    protected $abstractClass = false;

    /**
     * CodeGenerator constructor.
     */
    public function __construct()
    {
        $this->methods = [];
        $this->properties = [];
    }

    /**
     * @return Property[]
     */
    public function getConstants(): array
    {
        return $this->constants;
    }

    /**
     * @param Property[] $constants
     *
     * @return File
     */
    public function setConstants(array $constants): File
    {
        $this->constants = $constants;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAbstractClass(): bool
    {
        return $this->abstractClass;
    }

    /**
     * @param bool $abstractClass
     *
     * @return File
     */
    public function setAbstractClass(bool $abstractClass): File
    {
        $this->abstractClass = $abstractClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     *
     * @return File
     */
    public function setNamespace(string $namespace): File
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @return array
     */
    public function getUsedNamespaces()
    {
        return $this->usedNamespaces;
    }

    /**
     * @param array $usedNamespaces
     *
     * @return File
     */
    public function setUsedNamespaces(array $usedNamespaces): File
    {
        $this->usedNamespaces = $usedNamespaces;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNoFileExists(): bool
    {
        return $this->noFileExists;
    }

    /**
     * @param bool $noFileExists
     *
     * @return File
     */
    public function setNoFileExists(bool $noFileExists): File
    {
        $this->noFileExists = $noFileExists;

        return $this;
    }

    /**
     * @return bool
     */
    public function isStrict(): bool
    {
        return $this->strict;
    }

    /**
     * @param bool $strict
     *
     * @return File
     */
    public function setStrict(bool $strict): File
    {
        $this->strict = $strict;

        return $this;
    }

    /**
     * @return string
     */
    public function getClassComment()
    {
        return $this->classComment;
    }

    /**
     * @param string $classComment
     *
     * @return File
     */
    public function setClassComment(string $classComment): File
    {
        $this->classComment = $classComment;

        return $this;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     *
     * @return File
     */
    public function setClassName(string $className): File
    {
        $this->className = $className;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * @param string $extends
     *
     * @return File
     */
    public function setExtends(string $extends): File
    {
        $this->extends = $extends;

        return $this;
    }

    /**
     * @return array
     */
    public function getInterfaces()
    {
        return $this->interfaces;
    }

    /**
     * @param string $interfaces
     *
     * @return File
     */
    public function setInterfaces(array $interfaces): File
    {
        $this->interfaces = $interfaces;

        return $this;
    }

    /**
     * @return \MjrOne\CodeGeneratorBundle\Php\Document\Method[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param \MjrOne\CodeGeneratorBundle\Php\Document\Method[] $methods
     *
     * @return File
     */
    public function setMethods(array $methods): File
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param Property[] $properties
     *
     * @return File
     */
    public function setProperties(array $properties): File
    {
        $this->properties = $properties;

        return $this;
    }
}
