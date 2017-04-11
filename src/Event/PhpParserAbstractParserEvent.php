<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Document\Property as PropertyObject;
use MjrOne\CodeGeneratorBundle\Php\Document\Constants as ConstantsObject;
use MjrOne\CodeGeneratorBundle\Php\Parser\AbstractParser;
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
class PhpParserAbstractParserEvent extends Event
{
    /**
     * @var AbstractParser
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
     * @var bool
     */
    protected $arrayHandling=false;

    /**
     * @var ArrayCollection
     */
    protected $arrayRows;

    /**
     * @var array|string
     */
    protected $arrayRow;

    /**
     * @return ArrayCollection
     */
    public function getArrayRows(): ArrayCollection
    {
        return $this->arrayRows;
    }

    /**
     * @param ArrayCollection $arrayRows
     * @return PhpParserAbstractParserEvent
     */
    public function setArrayRows(ArrayCollection $arrayRows): PhpParserAbstractParserEvent
    {
        $this->arrayRows = $arrayRows;
        return $this;
    }

    /**
     * @return array|string
     */
    public function getArrayRow()
    {
        return $this->arrayRow;
    }

    /**
     * @param array|string $arrayRow
     * @return PhpParserAbstractParserEvent
     */
    public function setArrayRow($arrayRow)
    {
        $this->arrayRow = $arrayRow;
        return $this;
    }

    /**
     * @return bool
     */
    public function isArrayHandling(): bool
    {
        return $this->arrayHandling;
    }

    /**
     * @param bool $arrayHandling
     * @return PhpParserAbstractParserEvent
     */
    public function setArrayHandling(bool $arrayHandling): PhpParserAbstractParserEvent
    {
        $this->arrayHandling = $arrayHandling;
        return $this;
    }

    /**
     * @return AbstractParser
     */
    public function getSubject(): AbstractParser
    {
        return $this->subject;
    }

    /**
     * @param AbstractParser $subject
     * @return PhpParserAbstractParserEvent
     */
    public function setSubject(AbstractParser $subject): PhpParserAbstractParserEvent
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
     * @return PhpParserAbstractParserEvent
     */
    public function setTokens(array $tokens): PhpParserAbstractParserEvent
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
     * @return PhpParserAbstractParserEvent
     */
    public function setToken(Token $token): PhpParserAbstractParserEvent
    {
        $this->token = $token;
        return $this;
    }
}