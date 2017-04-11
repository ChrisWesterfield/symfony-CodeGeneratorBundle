<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorAbstract;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AddToListEvent
 *
 * @package   MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class AddToListEvent extends Event
{
    /**
     * @var CodeGeneratorInterface
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
     * @return CodeGeneratorInterface
     */
    public function getSubject(): GeneratorAbstract
    {
        return $this->subject;
    }

    /**
     * @param CodeGeneratorInterface $subject
     *
     * @return AddToListEvent
     */
    public function setSubject(CodeGeneratorInterface $subject): AddToListEvent
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
