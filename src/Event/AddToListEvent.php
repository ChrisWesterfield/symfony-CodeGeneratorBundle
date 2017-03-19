<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 19/03/2017
 * Time: 17:59
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\Driver\GeneratorInterface;
use Symfony\Component\EventDispatcher\Event;

class AddToListEvent extends Event
{
    /**
     * @var GeneratorInterface
     */
    protected $subject;
    /**
     * @var string
     */
    protected $class;
    /**
     * @var ArrayCollection
     */
    protected $list;
    /**
     * @var string|null
     */
    protected $alias;

    /**
     * @return \MjrOne\CodeGeneratorBundle\Services\Driver\GeneratorInterface
     */
    public function getSubject(): \MjrOne\CodeGeneratorBundle\Services\Driver\GeneratorInterface
    {
        return $this->subject;
    }

    /**
     * @param \MjrOne\CodeGeneratorBundle\Services\Driver\GeneratorInterface $subject
     *
     * @return AddToListEvent
     */
    public function setSubject(\MjrOne\CodeGeneratorBundle\Services\Driver\GeneratorInterface $subject): AddToListEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return AddToListEvent
     */
    public function setClass(string $class): AddToListEvent
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getList(): ArrayCollection
    {
        return $this->list;
    }

    /**
     * @param ArrayCollection $list
     *
     * @return AddToListEvent
     */
    public function setList(ArrayCollection $list): AddToListEvent
    {
        $this->list = $list;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param null|string $alias
     *
     * @return AddToListEvent
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }
}
