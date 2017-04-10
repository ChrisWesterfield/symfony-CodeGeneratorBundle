<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Php\Document\Property as PropertyObject;
use MjrOne\CodeGeneratorBundle\Php\Document\Constants as ConstantsObject;
use MjrOne\CodeGeneratorBundle\Php\Parser\Constants;
use MjrOne\CodeGeneratorBundle\Php\Parser\Property;
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
class PhpParserPropertyEvent extends Event
{
    /**
     * @var Property
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
     * @var PropertyObject
     */
    protected $propertyObject;

    /**
     * @var ArrayCollection
     */
    protected $arrayRows;

    /**
     * @var ArrayCollection
     */
    protected $properties;

    /**
     * @var Token
     */
    protected $lastToken;

    /**
     * @return \MjrOne\CodeGeneratorBundle\Php\Parser\Token
     */
    public function getLastToken(): \MjrOne\CodeGeneratorBundle\Php\Parser\Token
    {
        return $this->lastToken;
    }

    /**
     * @param \MjrOne\CodeGeneratorBundle\Php\Parser\Token $lastToken
     *
     * @return PhpParserPropertyEvent
     */
    public function setLastToken(\MjrOne\CodeGeneratorBundle\Php\Parser\Token $lastToken): PhpParserPropertyEvent
    {
        $this->lastToken = $lastToken;

        return $this;
    }

    /**
     * @return Property
     */
    public function getSubject(): Property
    {
        return $this->subject;
    }

    /**
     * @param Property $subject
     *
     * @return PhpParserPropertyEvent
     */
    public function setSubject(Property $subject): PhpParserPropertyEvent
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
     * @return PhpParserPropertyEvent
     */
    public function setTokens(array $tokens): PhpParserPropertyEvent
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
     * @return PhpParserPropertyEvent
     */
    public function setToken(Token $token): PhpParserPropertyEvent
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return PropertyObject
     */
    public function getPropertyObject(): PropertyObject
    {
        return $this->propertyObject;
    }

    /**
     * @param PropertyObject $propertyObject
     *
     * @return PhpParserPropertyEvent
     */
    public function setPropertyObject(PropertyObject $propertyObject
    ): PhpParserPropertyEvent
    {
        $this->propertyObject = $propertyObject;

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
     * @return PhpParserPropertyEvent
     */
    public function setArrayRows(ArrayCollection $arrayRows): PhpParserPropertyEvent
    {
        $this->arrayRows = $arrayRows;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProperties(): ArrayCollection
    {
        return $this->properties;
    }

    /**
     * @param ArrayCollection $properties
     *
     * @return PhpParserPropertyEvent
     */
    public function setProperties(ArrayCollection $properties): PhpParserPropertyEvent
    {
        $this->properties = $properties;

        return $this;
    }
}