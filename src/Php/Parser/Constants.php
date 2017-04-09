<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Event\PhpParserConstantEvent;
use MjrOne\CodeGeneratorBundle\Php\Document\Constants as DocConstants;
use ReflectionClass;

/**
 * Class Constants
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Parser
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Constants extends AbstractParser
{
    /**
     * @param string $source
     * @param array  $tokens
     * @param string $className
     *
     * @return array ;
     */
    public function parseDocument(string $source, array $tokens, string $className)
    {
        $arrayRows = new ArrayCollection();
        $constants = new ArrayCollection();
        $event = (new PhpParserConstantEvent())->setSubject($this)->setTokens($tokens)->setConstants($constants);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preProcess'),$event);
        $tokens = $event->getTokens();

        $constPrototype = new DocConstants();
        $constObject = $lastId = $lastToken = null;
        $constArrayValue = $equals = $arrayHandling = false;
        $bracketCounter = 0;
        $arrayRow = '';
        /** @var DocConstants $constObject */
        foreach ($tokens as $tokenRaw)
        {
            $token = new Token($tokenRaw);
            $event->setToken($token);
            $this->getED()->dispatch($this->getED()->getEventName(self::class,'preForeach'),$event);
            if ($token->isStringToken())
            {
                if ($token->tokenEquals('='))
                {
                    $equals = true;
                }
                if ($token->tokenEquals(';'))
                {
                    if ($arrayHandling && $constObject instanceof DocConstants)
                    {
                        if(!empty($arrayRow))
                        {
                            $this->addValue($arrayRows, $arrayRow);
                            $arrayRow = null;
                        }

                        $event->setArrayRows($arrayRows);
                        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preConstObjectAdd'),$event);

                        $constObject->setValue($arrayRows->toArray());
                        $arrayRows = new ArrayCollection();
                        $arrayHandling = false;
                        $bracketCounter = 0;
                    }
                    $equals = false;
                    if ($constObject instanceof DocConstants)
                    {
                        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preAdd'),$event);
                        $constants->add($constObject);
                        $constObject = null;
                    }
                }
                if ($token->tokenEquals('['))
                {
                    $this->addBracketOrArray($arrayRows, $arrayRow,$bracketCounter,$arrayHandling,'[');
                    if(is_array($arrayRow))
                    {
                        $arrayRow = null;
                    }
                }
                if ($token->tokenEquals(']'))
                {
                    if(!empty($arrayRow))
                    {
                        $this->addValue($arrayRows, $arrayRow);
                        $arrayRow = null;
                    }
                    if ($bracketCounter > 1)
                    {
                        $this->addValue($arrayRows, $this->getStringSeperators($bracketCounter - 1) . ']');
                    }
                    $bracketCounter--;
                }
                if ($arrayHandling && $token->tokenEquals(','))
                {
                    if (!empty($arrayRow) && $arrayRow !== self::SPACE_SEPERATORS)
                    {
                        $this->addValue($arrayRows, $arrayRow);
                        $arrayRow = null;
                    }
                    $constArrayValue = false;
                }
                if ($arrayHandling && $token->tokenEquals('('))
                {
                    if (!empty($arrayRow))
                    {
                        $this->addValue($arrayRows,$arrayRow);
                    }
                    if ($bracketCounter > 0)
                    {
                        $this->addValue($arrayRows,$this->getStringSeperators($bracketCounter) . '(');
                    }
                    $bracketCounter++;
                }
                if ($arrayHandling && $token->tokenEquals(')'))
                {
                    if(!empty($arrayRow))
                    {
                        $this->addValue($arrayRows, $arrayRow);
                        $arrayRow = null;
                    }
                    if ($bracketCounter > 1)
                    {
                        $this->addValue($arrayRows, $this->getStringSeperators($bracketCounter - 1) . ')');
                    }
                    $bracketCounter--;
                }
            }
            else
            {
                if ($token->isConstant())
                {
                    $constObject = clone $constPrototype;
                    $constObject->setVisibility($this->getModifier($lastToken));
                    $event->setConstantObject($constObject);
                    $this->getED()->dispatch($this->getED()->getEventName(self::class,'createConstObject'),$event);
                }
                if ($constObject instanceof DocConstants && !$constObject->hasName() && $token->isString())
                {
                    $constObject->setName($token->getName());
                    $this->getED()->dispatch($this->getED()->getEventName(self::class,'setName'),$event);
                }

                if ($constObject instanceof DocConstants && $equals && $constObject->hasName())
                {
                    if ($arrayHandling)
                    {
                        if ($bracketCounter >= 1)
                        {
                            $text = $this->getDataType($token, $arrayHandling);
                            if($token->isString() || $token->isEscapedString())
                            {
                                if (!$constArrayValue && !is_array($arrayRow))
                                {
                                    $arrayRow = $this->getStringSeperators($bracketCounter) . $text;
                                }
                                else
                                {
                                    if(is_array($arrayRow))
                                    {
                                        if(!$constArrayValue)
                                        {
                                            $arrayRow[] = $text;
                                        }
                                        else
                                        {
                                            if(count($arrayRow) === 1)
                                            {
                                                $arrayRow[] = $text;
                                            }
                                            else
                                            {
                                                $lastElement = array_pop($arrayRow);
                                                $lastElement .= $text;
                                                $arrayRow[] = $lastElement;
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $arrayRow .= $text;
                                    }
                                }
                            }
                            else
                                if ($token->isPaamayimNeukudotayim())
                            {
                                if(is_array($arrayRow))
                                {
                                    $lastElement = array_pop($arrayRow);
                                    $lastElement .= $text;
                                    $arrayRow[] = $lastElement;
                                }
                                else
                                {
                                    $arrayRow .= $text;
                                }
                                $constArrayValue = true;
                            }
                            else
                                if ($token->isDoubleArrow())
                            {
                                $arrayRow = [$arrayRow];
                            }
                            else
                            {
                                if(!empty($text))
                                {
                                    if(is_array($arrayRow) && $text === 'array')
                                    {
                                        $arrayRow[] = $text;
                                        $this->addValue($arrayRows,$arrayRow);
                                        $arrayRow = null;
                                    }
                                    else
                                    {
                                        $this->addValue($arrayRows,$this->getStringSeperators($bracketCounter) . $text);
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        if ($token->isArray())
                        {
                            $arrayHandling = true;
                        }
                        else
                        {
                            $constObject->setValue($this->getDataType($token, $arrayHandling));
                        }
                    }
                }

                if (!$token->isWhiteSpace())
                {
                    $lastToken = $token;
                }
            }
        }

        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preReturn'),$event);
        return $constants->toArray();
    }

    /**
     * @param $count
     *
     * @return string
     */
    protected function getStringSeperators($count)
    {
        $returnSpacers = '';
        for ($i = 0; $i < $count; $i++)
        {
            $returnSpacers .= self::SPACE_SEPERATORS;
        }

        return $returnSpacers;
    }
}
