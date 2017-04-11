<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Php\Document\Constants as ConstantsObject;
use MjrOne\CodeGeneratorBundle\Php\Parser\Constants;
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
class PhpParserConstantEvent extends Event
{
    /**
     * @var Constants
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
     * @var ConstantsObject
     */
    protected $constantObject;

    /**
     * @var ArrayCollection
     */
    protected $arrayRows;

    /**
     * @var ArrayCollection
     */
    protected $constants;

    /**
     * @return ArrayCollection
     */
    public function getConstants(): ArrayCollection
    {
        return $this->constants;
    }

    /**
     * @param ArrayCollection $constants
     * @return PhpParserConstantEvent
     */
    public function setConstants(ArrayCollection $constants): PhpParserConstantEvent
    {
        $this->constants = $constants;
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
     * @return PhpParserConstantEvent
     */
    public function setArrayRows(ArrayCollection $arrayRows): PhpParserConstantEvent
    {
        $this->arrayRows = $arrayRows;
        return $this;
    }

    /**
     * @return ConstantsObject
     */
    public function getConstantObject(): ConstantsObject
    {
        return $this->constantObject;
    }

    /**
     * @param ConstantsObject $constantObject
     * @return PhpParserConstantEvent
     */
    public function setConstantObject(ConstantsObject $constantObject): PhpParserConstantEvent
    {
        $this->constantObject = $constantObject;
        return $this;
    }

    /**
     * @return Constants
     */
    public function getSubject(): Constants
    {
        return $this->subject;
    }

    /**
     * @param Constants $subject
     * @return PhpParserConstantEvent
     */
    public function setSubject(Constants $subject): PhpParserConstantEvent
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
     * @return PhpParserConstantEvent
     */
    public function setTokens(array $tokens): PhpParserConstantEvent
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
     * @return PhpParserConstantEvent
     */
    public function setToken(Token $token): PhpParserConstantEvent
    {
        $this->token = $token;
        return $this;
    }
}