<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Php\Parser\AbstractParser;

/**
 * Class CodeGeneratorMethod
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Method Extends DocumentAbstract implements ParsedChildInterface
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
     * @var string|null
     */
    protected $methodReturn;

    /**
     * @return null|string
     */
    public function getMethodReturn()
    {
        return $this->methodReturn;
    }

    /**
     * @param null|string $methodReturn
     *
     * @return Method
     */
    public function setMethodReturn($methodReturn)
    {
        $this->methodReturn = $methodReturn;
        $this->updateFileContainer();

        return $this;
    }

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
    public function setVisibility(string $visibility=null): Method
    {
        if($visibility===null)
        {
            $visibility = AbstractParser::PUBLIC;
        }
        $this->visibility = $visibility;
        $this->updateFileContainer();

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
        $this->updateFileContainer();

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
        $this->updateFileContainer();

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
        $this->updateFileContainer();

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
        $this->updateFileContainer();

        return $this;
    }

    /**
     * @return Variable[]|array
     */
    public function getVariables()
    {
        return $this->variables!==null?$this->variables:[];
    }

    /**
     * @param Variable $variable
     *
     * @return Method
     */
    public function addVariable(Variable $variable):Method
    {
        $this->variables[] = $variable;
        $this->updateFileContainer();

        return $this;
    }

    /**
     * @return bool
     */
    public function hasName():bool
    {
        return !empty($this->name);
    }

    /**
     * @return bool
     */
    public function hasComment():bool
    {
        return !empty($this->comment);
    }

    /**
     * @return bool
     */
    public function hasVariables():bool
    {
        return !empty($this->variables);
    }

    /**
     * @param \array[]|null $variables
     * @return Method
     */
    public function setVariables(array $variables=null):Method
    {
        if($variables === null)
        {
            $variables = [];
        }
        $this->variables = $variables;
        $this->updateFileContainer();

        return $this;
    }
}
