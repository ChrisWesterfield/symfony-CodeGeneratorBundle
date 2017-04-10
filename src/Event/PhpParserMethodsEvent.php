<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Php\Document\Constants as ConstantsObject;
use MjrOne\CodeGeneratorBundle\Php\Document\Method as MethodObject;
use MjrOne\CodeGeneratorBundle\Php\Document\Variable;
use MjrOne\CodeGeneratorBundle\Php\Parser\Constants;
use MjrOne\CodeGeneratorBundle\Php\Parser\Method;
use MjrOne\CodeGeneratorBundle\Php\Parser\Token;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class PhpParserConstantEvent
 * @package MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class PhpParserMethodsEvent extends Event
{
    /**
     * @var Method
     */
    protected $subject;

    /**
     * @var array
     */
    protected $tokens;

    /**
     * @var Token
     */
    protected $token;

    /**
     * @var MethodObject
     */
    protected $methodObject;

    /**
     * @var ArrayCollection
     */
    protected $arrayRows;

    /**
     * @var ArrayCollection
     */
    protected $methods;

    /**
     * @var Token
     */
    protected $lastToken;

    /**
     * @var Variable
     */
    protected $variableObject;

    /**
     * @var ArrayCollection
     */
    protected $content;

    /**
     * @var array
     */
    protected $source;

    /**
     * @return Method
     */
    public function getSubject(): Method
    {
        return $this->subject;
    }

    /**
     * @param Method $subject
     *
     * @return PhpParserMethodsEvent
     */
    public function setSubject(Method $subject): PhpParserMethodsEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return array
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * @param array $tokens
     *
     * @return PhpParserMethodsEvent
     */
    public function setTokens(array $tokens): PhpParserMethodsEvent
    {
        $this->tokens = $tokens;

        return $this;
    }

    /**
     * @return Token
     */
    public function getToken(): Token
    {
        return $this->token;
    }

    /**
     * @param Token $token
     *
     * @return PhpParserMethodsEvent
     */
    public function setToken(Token $token): PhpParserMethodsEvent
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return MethodObject
     */
    public function getMethodObject(): MethodObject
    {
        return $this->methodObject;
    }

    /**
     * @param MethodObject $methodObject
     *
     * @return PhpParserMethodsEvent
     */
    public function setMethodObject(MethodObject $methodObject
    ): PhpParserMethodsEvent
    {
        $this->methodObject = $methodObject;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getArrayRows(): ArrayCollection
    {
        return $this->arrayRows;
    }

    /**
     * @param ArrayCollection $arrayRows
     *
     * @return PhpParserMethodsEvent
     */
    public function setArrayRows(ArrayCollection $arrayRows): PhpParserMethodsEvent
    {
        $this->arrayRows = $arrayRows;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMethods(): ArrayCollection
    {
        return $this->methods;
    }

    /**
     * @param ArrayCollection $methods
     *
     * @return PhpParserMethodsEvent
     */
    public function setMethods(ArrayCollection $methods): PhpParserMethodsEvent
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return Token
     */
    public function getLastToken(): Token
    {
        return $this->lastToken;
    }

    /**
     * @param Token $lastToken
     *
     * @return PhpParserMethodsEvent
     */
    public function setLastToken(Token $lastToken): PhpParserMethodsEvent
    {
        $this->lastToken = $lastToken;

        return $this;
    }

    /**
     * @return Variable
     */
    public function getVariableObject(): Variable
    {
        return $this->variableObject;
    }

    /**
     * @param Variable $variableObject
     *
     * @return PhpParserMethodsEvent
     */
    public function setVariableObject(Variable $variableObject
    ): PhpParserMethodsEvent
    {
        $this->variableObject = $variableObject;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getContent(): ArrayCollection
    {
        return $this->content;
    }

    /**
     * @param ArrayCollection $content
     *
     * @return PhpParserMethodsEvent
     */
    public function setContent(ArrayCollection $content): PhpParserMethodsEvent
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return array
     */
    public function getSource(): array
    {
        return $this->source;
    }

    /**
     * @param array $source
     *
     * @return PhpParserMethodsEvent
     */
    public function setSource(array $source): PhpParserMethodsEvent
    {
        $this->source = $source;

        return $this;
    }
}