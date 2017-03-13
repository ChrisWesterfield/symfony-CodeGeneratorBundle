<?php
declare(strict_types = 1);
/**
 * Created by Christopher Westerfield
 * copyright by Christopher Westerfield
 * Date: 24/12/2016
 * Time: 13:52
 */
namespace MjrOne\CodeGeneratorBundle\Annotation\Mutator;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;

/**
 * Class Mutator
 * @package CodeGeneratorBundle\Annotation\PropertyDefinition
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class Property extends AbstractAnnotation
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var bool
     */
    public $ignore=false;

    /**
     * enables getter methods (get<PROPERTY>)
     * @var bool
     */
    public $getter=true;

    /**
     * enables setter methods (set<PROPERTY>)
     * @var bool
     */
    public $setter=true;

    /**
     * enables is methods (is<PROPERTY>)
     * @var bool
     */
    public $is=true;

    /**
     * enables has methods (has<PROPERTY>)
     * @var bool
     */
    public $has=true;

    /**
     * enables iteratable extended methods (add,remove,count,...) for
     * Arrays
     * Iterable properties (currently only ArrayCollection and phpCollection)
     * @var bool
     */
    public $iterator=true;

    /**
     * enables count methods (count<PROPERTY>)
     * @var bool
     */
    public $count=true;

    /**
     * enables add methods (add<PROPERTY>)
     * @var bool
     */
    public $add=true;

    /**
     * enables remove methods (remove<PROPERTY>)
     * @var bool
     */
    public $remove=true;

    /**
     * @var bool
     */
    public $nullable;

    /**
     * @var bool
     */
    public $fluent = true;

    /**
     * @var string allowed settings: ** (empty, null), public , private, protected
     */
    public $visibility;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Property
     */
    public function setType(string $type): Property
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIgnore()
    {
        return $this->ignore;
    }

    public function isIgnore()
    {
        return $this->ignore;
    }

    /**
     * @param bool $ignore
     * @return Property
     */
    public function setIgnore(bool $ignore): Property
    {
        $this->ignore = $ignore;
        return $this;
    }

    /**
     * @return bool
     */
    public function getGetter()
    {
        return $this->getter;
    }

    public function isGetter()
    {
        return $this->getter;
    }

    /**
     * @param bool $getter
     * @return Property
     */
    public function setGetter(bool $getter): Property
    {
        $this->getter = $getter;
        return $this;
    }

    /**
     * @return bool
     */
    public function getSetter()
    {
        return $this->setter;
    }

    public function isSetter()
    {
        return $this->setter;
    }

    /**
     * @param bool $setter
     * @return Property
     */
    public function setSetter(bool $setter): Property
    {
        $this->setter = $setter;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIs()
    {
        return $this->is;
    }

    public function isIs()
    {
        return $this->is;
    }

    /**
     * @param bool $is
     * @return Property
     */
    public function setIs(bool $is): Property
    {
        $this->is = $is;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHas()
    {
        return $this->has;
    }

    public function isHas()
    {
        return $this->has;
    }

    /**
     * @param bool $has
     * @return Property
     */
    public function setHas(bool $has): Property
    {
        $this->has = $has;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIterator()
    {
        return $this->iterator;
    }

    public function isIterator()
    {
        return $this->iterator;
    }

    /**
     * @param bool $iterator
     * @return Property
     */
    public function setIterator(bool $iterator): Property
    {
        $this->iterator = $iterator;
        return $this;
    }

    /**
     * @return bool
     */
    public function getCount()
    {
        return $this->count;
    }

    public function isCount()
    {
        return $this->count;
    }

    /**
     * @param bool $count
     * @return Property
     */
    public function setCount(bool $count): Property
    {
        $this->count = $count;
        return $this;
    }

    /**
     * @return bool
     */
    public function getAdd()
    {
        return $this->add;
    }

    public function isAdd()
    {
        return $this->add;
    }

    /**
     * @param bool $add
     * @return Property
     */
    public function setAdd(bool $add): Property
    {
        $this->add = $add;
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
     * @return Property
     */
    public function setRemove(bool $remove): Property
    {
        $this->remove = $remove;
        return $this;
    }

    /**
     * @return bool
     */
    public function getNullable()
    {
        return $this->nullable;
    }

    public function isNullable()
    {
        return $this->nullable;
    }

    /**
     * @param bool $nullable
     * @return Property
     */
    public function setNullable(bool $nullable): Property
    {
        $this->nullable = $nullable;
        return $this;
    }

    /**
     * @return bool
     */
    public function getFluent()
    {
        return $this->fluent;
    }

    public function isFluent()
    {
        return $this->fluent;
    }

    /**
     * @param bool $fluent
     * @return Property
     */
    public function setFluent(bool $fluent): Property
    {
        $this->fluent = $fluent;
        return $this;
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     * @return Property
     */
    public function setVisibility(string $visibility): Property
    {
        $this->visibility = $visibility;
        return $this;
    }
}
