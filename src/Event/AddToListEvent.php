<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 19/03/2017
 * Time: 17:59
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Services\GeneratorService\Driver\GeneratorInterface;
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
     * @return GeneratorInterface
     */
    public function getSubject(): GeneratorInterface
    {
        return $this->subject;
    }

    /**
     * @param GeneratorInterface $subject
     *
     * @return AddToListEvent
     */
    public function setSubject(GeneratorInterface $subject): AddToListEvent
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
