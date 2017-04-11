<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Event\PhpParserAbstractParserEvent;
use MjrOne\CodeGeneratorBundle\Services\EventDispatcherService;

/**
 * Class AbstractParser
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Parser
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   LGPL V3
 * @link      http://www.mjr.one
 */
abstract class AbstractParser
{
    protected const    PRIVATE = 'private';
    protected const    PROTECTED = 'protected';
    protected const    PUBLIC = 'public';
    public    const    SPACE_SEPERATORS = '    ';
    public    const    VALUE_TRUE = 'true';
    public    const    VALUE_FALSE = 'false';
    public    const    TYPE_STRING = 'string';
    public    const    TYPE_MIXED = 'mixed';
    public    const    TYPE_BOOL = 'bool';
    public    const    TYPE_INT = 'int';
    public    const    TYPE_FLOAT = 'float';
    public    const    TYPE_ARRAY = 'array';
    protected const    TYPE_FUNCTION = 'function';
    protected const    TYPE_STRICT = 'strict_types';
    protected const    VALUE_STRICT = '1';

    // VAR
    protected const    VAR_PRIVATE = self::PRIVATE;
    protected const    VAR_PROTECTED = self::PROTECTED;
    protected const    VAR_PUBLIC = self::PUBLIC;
    protected const    VAR_ALLOWED = [
        T_PUBLIC,
        T_PRIVATE,
        T_PROTECTED,
    ];
    //constant Parameters
    protected const    CONST_PRIVATE = self::PRIVATE . '  ';
    protected const    CONST_PROTECTED = self::PROTECTED . '';
    protected const    CONST_PUBLIC = self::PUBLIC . '   ';
    protected const    CONST_STRING = 'const';
    protected const    CONST_ALLOWED = [
        T_PUBLIC,
        T_PRIVATE,
        T_PROTECTED,
    ];

    //Method Constants
    protected const METHOD_PRIVATE = self::PRIVATE;
    protected const METHOD_PROTECTED = self::PROTECTED;
    protected const METHOD_PUBLIC = self::PUBLIC;
    protected const METHOD_ALLOWED = [
        T_PUBLIC,
        T_PRIVATE,
        T_PROTECTED,
    ];

    /**
     * @var EventDispatcherService
     */
    protected $eventDispatcher;

    public function __construct(EventDispatcherService $dispatcher)
    {
        $this->eventDispatcher = $dispatcher;
    }

    /**
     * @return EventDispatcherService
     */
    public function getEventDispatcher(): EventDispatcherService
    {
        return $this->eventDispatcher;
    }

    /**
     * @return EventDispatcherService
     */
    public function getED()
    {
        return $this->getEventDispatcher();
    }

    /**
     * @param Token $token
     * @param bool $arrayHandling
     *
     * @return null|string
     */
    public function getDataType(Token $token, &$arrayHandling = false)
    {
        $event = (new PhpParserAbstractParserEvent())->setSubject($this)->setToken($token)->setArrayHandling($arrayHandling);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'getDataTypePre'),$event);
        $arrayHandling = $event->isArrayHandling();
        if ($token->isArray()) {
            if ($arrayHandling === false) {
                $arrayHandling = true;

                return (string)null;
            }

            return 'array';
        }
        $returnValue = null;
        if ($token->isInteger()) {
            $this->getED()->dispatch($this->getED()->getEventName(self::class,'getDataTypeGetIntPre'),$event);
            $returnValue = (int)$token->getText();
        }
        if ($token->isFloat()) {
            $this->getED()->dispatch($this->getED()->getEventName(self::class,'getDataTypeGetFloatPre'),$event);
            $returnValue = (float)$token->getText();
        }
        if ($token->isEscapedString()) {
            $this->getED()->dispatch($this->getED()->getEventName(self::class,'getDataTypeGetEscapedStringPre'),$event);
            $returnValue = (string)$token->getText();
        }
        if ($token->isString()) {
            $this->getED()->dispatch($this->getED()->getEventName(self::class,'getDataTypeGetStringPre'),$event);
            $returnValue = $token->getText();
            if (strtolower($returnValue) === 'true') {
                $returnValue = true;
            } else if (strtolower($returnValue) === 'false') {
                $returnValue = false;
            }
        }
        if ($token->isPaamayimNeukudotayim()) {
            $this->getED()->dispatch($this->getED()->getEventName(self::class,'getDataTypeGetPaamayimNeukodatayimPre'),$event);
            $returnValue = '::';
        }

        $this->getED()->dispatch($this->getED()->getEventName(self::class,'getDataTypeGetIntPreReturn'),$event);
        return $returnValue;
    }

    /**
     * @param Token $lastToken
     *
     * @return string
     */
    protected function getModifier(Token $lastToken): string
    {

        if ($lastToken->isProtected()) {
            return self::VAR_PROTECTED;
        }
        if ($lastToken->isPrivate()) {
            return self::VAR_PRIVATE;
        }

        return self::VAR_PUBLIC;
    }

    /**
     * @param $count
     *
     * @return string
     */
    protected function getStringSeperators($count)
    {
        $returnSpacers = '';
        for ($i = 0; $i < $count; $i++) {
            $returnSpacers .= self::SPACE_SEPERATORS;
        }

        return $returnSpacers;
    }

    /**
     * @param ArrayCollection $arrayRows
     * @param $arrayRow
     */
    protected function addValue(ArrayCollection $arrayRows, $arrayRow): void
    {
        $event = (new PhpParserAbstractParserEvent())->setSubject($this)->setArrayRows($arrayRows)->setArrayRow($arrayRow);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'addValuePre'),$event);
        $arrayRow = $event->getArrayRow();
        if (!empty($arrayRow)) {
            if (is_array($arrayRow)) {
                $firstElement = array_shift($arrayRow);
                if (substr($firstElement, 0, 4) !== self::SPACE_SEPERATORS) {
                    $firstElement = self::SPACE_SEPERATORS . $firstElement;
                }
                $lastElement = array_pop($arrayRow);
                $check = trim($lastElement);
                if (!in_array($check, ['[', '(', 'array'])) {
                    $lastElement .= ',';
                }
                $arrayRow = [
                    $firstElement,
                    $lastElement
                ];
                $this->getED()->dispatch($this->getED()->getEventName(self::class,'addValuePreAddArray'),$event);
                $arrayRows->add($arrayRow);
            } else {
                if (strpos($arrayRow, '[') === false && strpos($arrayRow, '(') === false && trim($arrayRow) !== 'array') {
                    $arrayRow .= ',';
                }
                if (substr($arrayRow, 0, 4) !== self::SPACE_SEPERATORS) {
                    $arrayRow = self::SPACE_SEPERATORS . $arrayRow;
                }
                $this->getED()->dispatch($this->getED()->getEventName(self::class,'addValuePreAddString'),$event);
                $arrayRows->add($arrayRow);
            }
        }
    }

    /** @noinspection MoreThanThreeArgumentsInspection */
    /**
     * @param ArrayCollection $arrayRows
     * @param $arrayRow
     * @param $bracketCounter
     * @param bool $arrayHandling
     * @param string $bracketChar
     */
    public function addBracketOrArray(ArrayCollection $arrayRows, $arrayRow, &$bracketCounter, bool &$arrayHandling, string $bracketChar)
    {
        $arrayHandling = true;
        $bracketCounter++;
        if ($bracketCounter > 1) {
            if (is_array($arrayRow) && !empty($arrayRow)) {
                /** @var array $arrayRow */
                $first = array_shift($arrayRow);
                $first = ltrim($first);
                $arrayRow = [
                    $this->getStringSeperators($bracketCounter - 1) . $first,
                    $bracketChar
                ];
                $this->addValue($arrayRows, $arrayRow);
            } else {
                $this->addValue($arrayRows, $this->getStringSeperators($bracketCounter - 1) . '[');
            }
        }
    }
}