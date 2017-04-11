<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;
use MjrOne\CodeGeneratorBundle\Annotation\ClassInterface;
use MjrOne\CodeGeneratorBundle\Annotation\DriverInterface;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorMutator;

/**
 * Class Mutator
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @package MjrOne\CodeGeneratorBundle\Annotation\Mutator
 * @author    Chris Westerfield <chris@mjr.one>
 * @Annotation
 * @Target({"CLASS"})
 */
final class Mutator extends AbstractAnnotation implements ClassInterface, DriverInterface
{
    const DRIVER = CodeGeneratorMutator::class;
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
     * @var string allowed settings: *public*, private, protected
     */
    public $visibility = 'public';

    /**
     * Ignore all properties except defined
     * @var bool
     */
    public $ignore=false;

    /**
     * @var bool
     */
    public $nullable;

    /**
     * @var bool
     */
    public $fluent = true;

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
     * @return Mutator
     */
    public function setGetter(bool $getter): Mutator
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
     * @return Mutator
     */
    public function setSetter(bool $setter): Mutator
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
     * @return Mutator
     */
    public function setIs(bool $is): Mutator
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
     * @return Mutator
     */
    public function setHas(bool $has): Mutator
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
     * @return Mutator
     */
    public function setIterator(bool $iterator): Mutator
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
     * @return Mutator
     */
    public function setCount(bool $count): Mutator
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
     * @return Mutator
     */
    public function setAdd(bool $add): Mutator
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
     * @return Mutator
     */
    public function setRemove(bool $remove): Mutator
    {
        $this->remove = $remove;
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
     * @return Mutator
     */
    public function setVisibility(string $visibility): Mutator
    {
        $this->visibility = $visibility;
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
     * @return Mutator
     */
    public function setIgnore(bool $ignore): Mutator
    {
        $this->ignore = $ignore;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * @param bool $nullable
     *
     * @return Mutator
     */
    public function setNullable(bool $nullable): Mutator
    {
        $this->nullable = $nullable;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFluent(): bool
    {
        return $this->fluent;
    }

    /**
     * @param bool $fluent
     *
     * @return Mutator
     */
    public function setFluent(bool $fluent): Mutator
    {
        $this->fluent = $fluent;

        return $this;
    }
}
