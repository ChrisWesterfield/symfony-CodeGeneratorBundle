<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Document;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var Method[]|ArrayCollection
     */
    protected $methods;

    /**
     * @var Property[]|ArrayCollection
     */
    protected $properties;

    /**
     * @var Property[]|ArrayCollection
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
     * @var bool
     */
    protected $updateNeeded;

    /**
     * @var array
     */
    protected $traitUses;

    /**
     * CodeGenerator constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->traitUses = [];
        $this->methods = new ArrayCollection();
        $this->properties = new ArrayCollection();
        $this->constants = new ArrayCollection();
    }

    /**
     * @return array
     */
    public function getTraitUses(): array
    {
        if($this->traitUses === null)
        {
            $this->traitUses = [];
        }

        return $this->traitUses;
    }

    /**
     * @param array $traitUses
     * @return File
     */
    public function setTraitUses(array $traitUses): File
    {
        $this->traitUses = $traitUses;
        return $this;
    }

    /**
     * @param string $trait
     *
     * @return bool
     */
    public function hasTraitUse(string $trait=null):bool
    {
        return in_array((string)$trait, $this->traitUses, true);
    }

    /**
     * @param string $trait
     *
     * @return File
     */
    public function addTraitUse(string $trait):File
    {
        $this->traitUses[] = $trait;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUpdateNeeded():bool
    {
        return $this->updateNeeded;
    }

    /**
     * @return DocumentInterface
     */
    public function setUpdateNeeded():DocumentInterface
    {
        if($this->parent instanceof File)
        {
            $this->parent->setUpdateNeeded();
        }

        return $this;
    }

    /**
     * @return Property[]|ArrayCollection
     */
    public function getConstants():ArrayCollection
    {
        return $this->constants;
    }

    /**
     * @param Property[]|ArrayCollection $constants
     *
     * @return File
     */
    public function setConstants(ArrayCollection $constants): File
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
     * @param array $interfaces
     *
     * @return File
     */
    public function setInterfaces(array $interfaces): File
    {
        $this->interfaces = $interfaces;

        return $this;
    }

    /**
     * @return Method[]|ArrayCollection
     */
    public function getMethods():ArrayCollection
    {
        return $this->methods;
    }

    /**
     * @param Method[]|ArrayCollection $methods
     *
     * @return File
     */
    public function setMethods(ArrayCollection $methods): File
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return Property[]|ArrayCollection
     */
    public function getProperties():ArrayCollection
    {
        return $this->properties;
    }

    /**
     * @param Property[]|ArrayCollection $properties
     *
     * @return File
     */
    public function setProperties(ArrayCollection $properties): File
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasMethods():bool
    {
        return $this->methods->count() > 0;
    }

    /**
     * @return bool
     */
    public function hasProperties():bool
    {
        return $this->properties->count() > 0;
    }

    /**
     * @return bool
     */
    public function hasConstants():bool
    {
        return $this->constants->count() > 0;
    }

    /**
     * @param Method $method
     * @return File
     */
    public function addMethod(Method $method):File
    {
        $this->methods->add($method);

        return $this;
    }

    /**
     * @param Property $property
     * @return File
     */
    public function addProperty(Property $property):File
    {
        $this->properties->add($property);

        return $this;
    }

    /**
     * @param Constants $constant
     * @return File
     */
    public function addConstant(Constants $constant):File
    {
        $this->constants->add($constant);

        return $this;
    }

    /**
     * @param string $name
     * @return int|false
     */
    public function getMethodId(string $name)
    {
        return $this->searchField($name, 'methods');
    }

    /**
     * @param string $name
     * @return int|false
     */
    public function getPropertyId(string $name)
    {
        return $this->searchField($name, 'properties');
    }

    /**
     * @param string $name
     * @return int|false
     */
    public function getConstantId(string $name)
    {
        return $this->searchField($name, 'constants');
    }

    /**
     * @param string $name
     * @param $identifier
     * @return bool|int|string
     */
    protected function searchField(string $name, $identifier)
    {
        if($this->{$identifier}->count() < 1)
        {
            return false;
        }
        foreach($this->$identifier as $id=>$object)
        {
            /** @var ParsedChildInterface $object */
            if($object->getName() === $name)
            {
                return $id;
            }
        }
        return false;
    }

    /**
     * @param string $namespace
     * @return bool
     */
    public function hasUsedNamespace(string $namespace):bool
    {
        foreach($this->usedNamespaces as $usedNamespace)
        {
            if ($usedNamespace === $namespace || strpos(str_replace(' ','',$usedNamespace),$namespace.'as')!==false)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $namespace
     * @return File
     */
    public function addUsedNamespace(string $namespace):File
    {
        $this->usedNamespaces[] = $namespace;

        return $this;
    }
}
