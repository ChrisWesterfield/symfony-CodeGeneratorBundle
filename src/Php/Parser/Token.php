<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class Token
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Parser
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   LGPL V3
 * @link      http://www.mjr.one
 */
class Token
{
    private const NULL_TYPE = 'null';
    /**
     * @var int|null
     */
    protected $type;

    /**
     * @var string|null
     */
    protected $text;

    /**
     * @var int|null
     */
    protected $lineNumber;

    /**
     * @var bool
     */
    protected $stringToken=false;

    /**
     * @var mixed|string|array
     */
    protected $raw;

    /**
     * Token constructor.
     *
     * @param array|string $token
     */
    public function __construct($token)
    {
        $this->raw = $token;
        if(is_string($token))
        {
            $this->stringToken = true;
        }
        else
        {
            list($this->type, $this->text, $this->lineNumber) = $token;
        }
    }

    /**
     * @param string $equals
     *
     * @return bool
     */
    public function tokenEquals(string $equals):bool
    {
        return $this->raw === $equals;
    }

    /**
     * @return array|mixed|string
     */
    public function getToken()
    {
        return $this->raw;
    }

    /**
     * @return int|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return null|string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return int|null
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @return bool
     */
    public function isStringToken(): bool
    {
        return $this->stringToken;
    }

    /**
     * @param int $type
     *
     * @return bool
     */
    public function equals(int $type):bool
    {
        if($this->type === null)
        {
            return false;
        }
        return $this->type === $type;
    }

    /**
     * @return bool
     */
    public function isFunction():bool
    {
        return $this->equals(T_FUNCTION);
    }

    /**
     * @return bool
     */
    public function isString():bool
    {
        return $this->equals(T_STRING);
    }

    /**
     * @return bool
     */
    public function isInteger():bool
    {
        return $this->equals(T_LNUMBER);
    }

    /**
     * @return bool
     */
    public function isFloat():bool
    {
        return $this->equals(T_DNUMBER);
    }

    /**
     * @return bool
     */
    public function isEscapedString():bool
    {
        return $this->equals(T_CONSTANT_ENCAPSED_STRING);
    }

    /**
     * @return bool
     */
    public function isArray():bool
    {
        return $this->equals(T_ARRAY);
    }

    /**
     * @return bool
     */
    public function isPublic():bool
    {
        return $this->equals(T_PUBLIC);
    }

    /**
     * @return bool
     */
    public function isProtected():bool
    {
        return $this->equals(T_PROTECTED);
    }

    /**
     * @return bool
     */
    public function isPrivate():bool
    {
        return $this->equals(T_PRIVATE);
    }

    /**
     * @return bool
     */
    public function isConstant():bool
    {
        return $this->equals(T_CONST);
    }

    /**
     * @return bool
     */
    public function isVariable():bool
    {
        return $this->equals(T_VARIABLE);
    }

    /**
     * @return bool
     */
    public function isClass():bool
    {
        return $this->equals(T_CLASS);
    }

    /**
     * @return bool
     */
    public function isComment():bool
    {
        return $this->equals(T_COMMENT);
    }

    /**
     * @return bool
     */
    public function isDocComment():bool
    {
        return $this->equals(T_DOC_COMMENT);
    }

    /**
     * @return bool
     */
    public function isAbstract():bool
    {
        return $this->equals(T_ABSTRACT);
    }

    /**
     * @return bool
     */
    public function isFinal():bool
    {
        return $this->equals(T_FINAL);
    }

    /**
     * @return bool
     */
    public function isExtends():bool
    {
        return $this->equals(T_EXTENDS);
    }

    /**
     * @return bool
     */
    public function isImplements():bool
    {
        return $this->equals(T_IMPLEMENTS);
    }

    /**
     * @return bool
     */
    public function isUse():bool
    {
        return $this->equals(T_USE);
    }

    /**
     * @return bool
     */
    public function isPaamayimNeukudotayim():bool
    {
        return $this->equals(T_PAAMAYIM_NEKUDOTAYIM);
    }

    /**
     * @return bool
     */
    public function isWhiteSpace():bool
    {
        return $this->equals(T_WHITESPACE);
    }

    public function isNullable()
    {
        return $this->isString() && (strtolower($this->text)===self::NULL_TYPE);
    }

    /**
     * @return string
     */
    public function getName():string
    {
        if(empty($this->text))
        {
            return (string)$this->text;
        }
        $name = $this->text;
        $name = trim($name);
        if($name[0] === '$')
        {
            $name = substr($name,1);
        }
        return $name;
    }

    /**
     * @return bool
     */
    public function isNamespace():bool
    {
        return $this->equals(T_NAMESPACE);
    }

    /**
     * @return bool
     */
    public function isNamespaceSeperator():bool
    {
        return $this->equals(T_NS_SEPARATOR);
    }

    /**
     * @return bool
     */
    public function isNameSpaceElement():bool
    {
        return $this->isString()||$this->isNamespaceSeperator();
    }

    /**
     * @return bool
     */
    public function isDeclare():bool
    {
        return $this->equals(T_DECLARE);
    }

    /**
     * @param $text
     * @return bool
     */
    public function equalsText($text):bool
    {
        return $this->text === $text;
    }

    /**
     * @return bool
     */
    public function isDoubleArrow():bool
    {
        return $this->equals(T_DOUBLE_ARROW);
    }

    /**
     * @return bool
     */
    public function isAs():bool
    {
        return $this->equals(T_AS);
    }
}
