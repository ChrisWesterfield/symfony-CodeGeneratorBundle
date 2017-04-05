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
     * @var bool
     */
    protected $updateNeeded;

    public function __construct(DocumentInterface $parent=null)
    {
        $this->parent = $parent;
        $this->updateNeeded = false;
    }

    /**
     * @return DocumentInterface
     */
    public function setUpdateNeeded():DocumentInterface
    {
        $this->updateNeeded = true;
        if($this->parent instanceof DocumentInterface)
        {
            $this->parent->setUpdateNeeded();
        }

        return $this;
    }

    /**
     * @return DocumentInterface
     */
    public function resetUpdateNeeded():DocumentInterface
    {
        $this->updateNeeded = false;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUpdateNeeded(): bool
    {
        return $this->updateNeeded;
    }
}
