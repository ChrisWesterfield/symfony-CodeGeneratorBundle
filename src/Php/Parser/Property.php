<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Php\Document\Property as DocProperty;

/**
 * Class Property
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Parser
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Property extends AbstractParser
{
    /**
     * @param string $source
     * @param array  $tokens
     *
     * @return array;
     */
    public function parseDocument(string $source, array $tokens)
    {
        $arrayRows = new ArrayCollection();
        $properties = new ArrayCollection();
        $propertyPrototype = new DocProperty();
        $propertyComment = $propertyObject = $lastToken = null;
        $arrayHandling = $function = $equals = $constLink = false;
        $arrayRow = null;
        $functionBrackets = $bracketCounter = 0;
        foreach ($tokens as $tokenArray)
        {
            $token = new Token($tokenArray);
            if ($token->isStringToken())
            {
                if (!$function && $token->tokenEquals('='))
                {
                    $equals = true;
                }
                if (!$function && $propertyObject instanceof DocProperty && $token->tokenEquals(';'))
                {
                    if($arrayRow !== null)
                    {
                        $this->addValue($arrayRows, $arrayRow);
                        $arrayRow = null;
                    }
                    if(!empty($arrayRows) && $arrayHandling)
                    {
                        $propertyObject->setDefaultValue($arrayRows);
                        $arrayRows = new ArrayCollection();
                    }
                    $properties->add($propertyObject);
                    $propertyComment = $propertyObject = $lastToken = null;
                    $arrayHandling = $function = $equals = false;
                }
                if ($propertyObject instanceof DocProperty && !$function && $token->tokenEquals('['))
                {
                    $this->addBracketOrArray($arrayRows, $arrayRow, $bracketCounter, $arrayHandling,'[');
                    if(is_array($arrayRow))
                    {
                        $arrayRow = null;
                    }
                }
                if ($propertyObject instanceof DocProperty && !$function && $arrayHandling && $token->tokenEquals(']'))
                {
                    if(!empty($arrayRow))
                    {
                        $this->addValue($arrayRows, $arrayRow);
                        $arrayRow = null;
                    }
                    if ($bracketCounter > 1)
                    {
                        $this->addValue($arrayRows,$this->getStringSeperators($bracketCounter - 1) . ']');
                    }
                    $bracketCounter--;
                }
                if ($propertyObject instanceof DocProperty && !$function && $arrayHandling && $token->tokenEquals(','))
                {
                    if ($arrayRow !== null)
                    {
                        $this->addValue($arrayRows, $arrayRow);
                    }
                    $arrayRow = null;
                    $constLink = false;
                }
                if ($propertyObject instanceof DocProperty && !$function && $arrayHandling && $token->tokenEquals('('))
                {
                    if (!empty($arrayRow))
                    {
                        $this->addValue($arrayRows, $arrayRow);
                    }
                    if ($bracketCounter > 0)
                    {
                        $this->addValue($arrayRows,$this->getStringSeperators($bracketCounter) . '(');
                    }
                    $bracketCounter++;
                }
                if ($propertyObject instanceof DocProperty && !$function && $arrayHandling && $token->tokenEquals(')'))
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
                if($token->tokenEquals('{'))
                {
                    $functionBrackets++;
                }
                if ($function && $token->tokenEquals('}'))
                {
                    $functionBrackets--;
                    if($functionBrackets < 1)
                    {
                        $function = false;
                        $equals = false;
                    }
                }
            }
            else
            {
                if ($token->isFunction())
                {
                    $function = true;
                }
                if (!$function && $token->isDocComment())
                {
                    $propertyComment = $token->getText();
                }
                if (!$function && $token->isVariable())
                {
                    $propertyObject = $this->getPropertyObject($token, $lastToken, $propertyPrototype);
                    if (!empty($propertyComment))
                    {
                        $propertyObject->setComment($propertyComment);
                    }
                }
                if (
                    !$function
                    &&
                    $propertyObject instanceof DocProperty
                    &&
                    $equals
                    &&
                    !$token->isWhiteSpace()
                    &&
                    !$token->isVariable()
                )
                {
                    if ($arrayHandling)
                    {
                        $text = $this->getDataType($token, $arrayHandling);
                        if ($token->isString() || $token->isEscapedString())
                        {
                            if (!$constLink && !is_array($arrayRow))
                            {
                                $arrayRow = $this->getStringSeperators($bracketCounter) . $text;
                            }
                            else
                            {
                                if(is_array($arrayRow))
                                {
                                    if(!$constLink)
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
                        else if ($token->isPaamayimNeukudotayim())
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
                            $constLink = true;
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
                    else
                    {
                        if ($token->isArray())
                        {
                            $arrayHandling = true;
                        }
                        else
                        {
                            if($token->isNullable())
                            {
                                $propertyObject->setNulled();
                            }
                            else
                            {
                                $propertyObject->setDefaultValue($this->getDataType($token, $arrayHandling));
                            }
                        }
                    }
                }
                if(!$token->isWhiteSpace())
                {
                    $lastToken = $token;
                }
            }
        }

        return $properties->toArray();
    }


    /**
     * @param Token       $token
     * @param Token       $lastToken
     * @param DocProperty $propertyPrototype
     *
     * @return \MjrOne\CodeGeneratorBundle\Php\Document\Property
     */
    public function getPropertyObject(
        Token $token,
        Token $lastToken = null,
        DocProperty $propertyPrototype
    ): DocProperty
    {
        /** @var  $propertyObject */
        $propertyObject = clone $propertyPrototype;
        if ($lastToken instanceof Token)
        {
            $propertyObject->setVisibility($this->getModifier($lastToken));
        }
        $propertyObject->setName($token->getName());

        return $propertyObject;
    }
}
