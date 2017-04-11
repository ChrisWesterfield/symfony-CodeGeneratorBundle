<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Exception\MethodDoesNotExistException;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class DocumentAbstract
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   LGPL V3
 * @link      http://www.mjr.one
 */
class DocumentAbstract implements DocumentInterface
{
    /**
     * @var DocumentInterface|null
     */
    protected $parent=null;

    /**
     * DocumentAbstract constructor.
     * @param DocumentInterface|null $parent
     */
    public function __construct(DocumentInterface $parent=null)
    {
        $this->parent = $parent;
    }

    /**
     * @return DocumentInterface
     */
    public function updateFileContainer():DocumentInterface
    {
        if($this->parent instanceof File)
        {
            $this->parent->setUpdateNeeded();
        }

        return $this;
    }

    /**
     * @param DocumentInterface|null $parent
     * @return DocumentAbstract
     */
    public function setParent($parent):DocumentAbstract
    {
        $this->parent = $parent;
        return $this;
    }
}
