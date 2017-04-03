<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class CodeGeneratorMethod
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Parser\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Method
{
    /**
     * @var string
     */
    protected $mutator;

    /**
     * @var string
     */
    protected $methodName;

    /**
     * @var bool
     */
    protected $final=false;

    /**
     * @var string[]
     */
    protected $body;

    /**
     * @var string[]
     */
    protected $comment;

    /**
     * @return string
     */
    public function getMutator(): string
    {
        return $this->mutator;
    }

    /**
     * @param string $mutator
     *
     * @return Method
     */
    public function setMutator(string $mutator): Method
    {
        $this->mutator = $mutator;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     *
     * @return Method
     */
    public function setMethodName(string $methodName): Method
    {
        $this->methodName = $methodName;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFinal(): bool
    {
        return $this->final;
    }

    /**
     * @param bool $final
     *
     * @return Method
     */
    public function setFinal(bool $final): Method
    {
        $this->final = $final;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @param \string[] $body
     *
     * @return Method
     */
    public function setBody(array $body): Method
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getComment(): array
    {
        return $this->comment;
    }

    /**
     * @param \string[] $comment
     *
     * @return Method
     */
    public function setComment(array $comment): Method
    {
        $this->comment = $comment;

        return $this;
    }
}
