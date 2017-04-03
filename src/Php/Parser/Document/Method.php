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
    protected $visibility;

    /**
     * @var string
     */
    protected $name;

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
     * @var array[]
     */
    protected $variables;

    /**
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     *
     * @return Method
     */
    public function setVisibility(string $visibility): Method
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Method
     */
    public function setName(string $name): Method
    {
        $this->name = $name;

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

    /**
     * @param Variable $variable
     *
     * @return Method
     */
    public function addVariable(Variable $variable):Method
    {
        $this->variables[] = $variable;

        return $this;
    }
}
