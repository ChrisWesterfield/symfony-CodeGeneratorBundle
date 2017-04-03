<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class CodeGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class CodeGenerator
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
     * @var CodeGeneratorMethod[]
     */
    protected $methods;

    /**
     * @var CodeGeneratorProperty[]
     */
    protected $properties;

    /**
     * @var CodeGeneratorProperty[]
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
     * @return CodeGeneratorProperty[]
     */
    public function getConstants(): array
    {
        return $this->constants;
    }

    /**
     * @param CodeGeneratorProperty[] $constants
     *
     * @return CodeGenerator
     */
    public function setConstants(array $constants): CodeGenerator
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
     * @return CodeGenerator
     */
    public function setAbstractClass(bool $abstractClass): CodeGenerator
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
     * @return CodeGenerator
     */
    public function setNamespace(string $namespace): CodeGenerator
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
     * @return CodeGenerator
     */
    public function setUsedNamespaces(array $usedNamespaces): CodeGenerator
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
     * @return CodeGenerator
     */
    public function setNoFileExists(bool $noFileExists): CodeGenerator
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
     * @return CodeGenerator
     */
    public function setStrict(bool $strict): CodeGenerator
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
     * @return CodeGenerator
     */
    public function setClassComment(string $classComment): CodeGenerator
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
     * @return CodeGenerator
     */
    public function setClassName(string $className): CodeGenerator
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
     * @return CodeGenerator
     */
    public function setExtends(string $extends): CodeGenerator
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
     * @return CodeGenerator
     */
    public function setInterfaces(array $interfaces): CodeGenerator
    {
        $this->interfaces = $interfaces;

        return $this;
    }

    /**
     * @return \MjrOne\CodeGeneratorBundle\Document\CodeGeneratorMethod[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param \MjrOne\CodeGeneratorBundle\Document\CodeGeneratorMethod[] $methods
     *
     * @return CodeGenerator
     */
    public function setMethods(array $methods): CodeGenerator
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return CodeGeneratorProperty[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param CodeGeneratorProperty[] $properties
     *
     * @return CodeGenerator
     */
    public function setProperties(array $properties): CodeGenerator
    {
        $this->properties = $properties;

        return $this;
    }
}
