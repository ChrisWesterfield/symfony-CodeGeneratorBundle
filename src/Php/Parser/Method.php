<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Event\PhpParserMethodsEvent;
use MjrOne\CodeGeneratorBundle\Php\Document\Method as DocMethod;
use MjrOne\CodeGeneratorBundle\Php\Document\Variable;

/**
 * Class Method
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Parser
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Method extends AbstractParser
{
    /**
     * @param string $source
     * @param array  $tokens
     *
     * @return array;
     */
    public function parseDocument(string $source, array $tokens)
    {
        $sourceArray = explode("\n", $source);
        $methods = new ArrayCollection();
        $methodPrototype = new DocMethod();
        $variablePrototype = new Variable();

        $event = (new PhpParserMethodsEvent())
            ->setTokens($tokens)
            ->setSubject($this)
            ->setMethods($methods);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'parseDocumentPre'),$event);
        $tokens = $event->getTokens();
        $comment = $modifier = $lastToken = $variableObject = $type = $methodObject = null;
        $arrayObject = $nsDefinition = $functionEnd = $methodReturn = $final = $functions = $valueDefinition = false;
        $bracketCount = 0;
        $currentElement = $variableArray = [];
        $ampersAnd = false;
        foreach ($tokens as $tokenRaw)
        {
            $token = new Token($tokenRaw);
            if (!$token->isStringToken())
            {
                if ($token->isFinal())
                {
                    $final = true;
                }
                if ($token->isDocComment())
                {
                    $comment = $token->getText();
                }
                if ($token->isFunction())
                {
                    $methodObject = clone $methodPrototype;

                    $event->setToken($token)->setLastToken($lastToken);
                    $this->getED()->dispatch($this->getED()->getEventName(self::class, 'parseDocumentObjectPreCreate'), $event);

                    $methodObject->setVisibility($this->getModifier($lastToken));
                    $comment = explode("\n",$comment);
                    $newComment = [];
                    foreach($comment as $com)
                    {
                        $newComment[] = str_replace('     *      *', '     *', $com);
                    }
                    $methodObject->setComment($newComment);
                    $methodObject->setFinal($final);
                    $this->getED()->dispatch($this->getED()->getEventName(self::class, 'parseDocumentObjectPostCreate'), $event);
                    $functions = true;
                }
                if ($functions === true && !$methodObject->hasName() && $token->isString())
                {
                    $methodObject->setName($token->getName());
                }
                if($functions && $token->isNamespaceSeperator())
                {
                    $nsDefinition = true;
                }
                if ($functions && $token->isVariable() && !($variableObject instanceof Variable))
                {
                    if($lastToken !== null && $lastToken->isString())
                    {
                        $type = $lastToken->getText();
                    }
                    else
                    {
                        $type = null;
                    }
                    $variableObject = clone $variablePrototype;
                    $event->setVariableObject($variableObject);
                    $this->getED()->dispatch($this->getED()->getEventName(self::class, 'parseDocumentVariableObjectPreCreate'), $event);

                    $variableObject->setName(str_replace('$', '', $token->getText()));
                    if ($type !== null && $type !== 'false')
                    {
                        $variableObject->setType($type);
                    }
                    if($lastToken instanceof Token && $lastToken->isString())
                    {
                        $variableObject->setType(($nsDefinition?'\\':'').$lastToken->getText());
                    }
                    $valueDefinition = true;
                    $nsDefinition = false;
                    $variableObject->setAmpersAnd($ampersAnd);
                    $ampersAnd = false;
                    $this->getED()->dispatch($this->getED()->getEventName(self::class, 'parseDocumentVaraibleObjectPostCreate'), $event);
                }

                if($functions && $variableObject instanceof Variable && $token->isArray())
                {
                    if(!$arrayObject)
                    {
                        $arrayObject = true;
                    }
                }

                if ($functions && $valueDefinition && !$token->isVariable() && $variableObject instanceof Variable)
                {
                    if($arrayObject && $bracketCount > 0)
                    {
                        if($token->isArray())
                        {
                            if(count($currentElement) >= 1)
                            {
                                $currentElement[] = $token->getText();
                                $variableArray[] = $currentElement;
                                $currentElement = [];
                            }
                            else
                            {
                                $variableArray[] = $token->getText();
                            }
                        }
                        else
                            if(!$token->isDoubleArrow() && !$token->isWhiteSpace())
                        {
                            $currentElement[] = $token->getText();
                        }
                    }
                    else
                        if(!$arrayObject && !$token->isWhiteSpace())
                    {
                        $text = $this->getDataType($token);
                        $variableObject->setDefaultValue($text);
                        if (
                            (
                                $text === self::VALUE_TRUE
                                ||
                                $text === self::VALUE_FALSE
                            )
                            &&
                            $variableObject->getType() === self::TYPE_STRING
                        )
                        {
                            $variableObject->setType('bool');
                        }
                        if ($token->isNullable())
                        {
                            $variableObject->setNulled(true);
                        }
                        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'parseDocumentVariableObjectPreAdd'), $event);
                        $methodObject->addVariable($variableObject);
                        $variableObject = null;
                    }
                }

                if ($functions && $functionEnd && $methodReturn && $token->isString())
                {
                    $methodObject->setMethodReturn($token->getText());
                    $functionEnd = false;
                    $methodReturn = false;
                }
            }
            else
            {
                if($functions && $token->tokenEquals('&'))
                {
                    $ampersAnd = true;
                }
                if($functions && $variableObject instanceof Variable && $token->tokenEquals(','))
                {
                    if($arrayObject && $bracketCount > 0)
                    {
                        if(!empty($currentElement))
                        {
                            $variableArray[] = $currentElement;
                            $currentElement = [];
                        }
                    }
                    else if($bracketCount < 1 && !$arrayObject)
                    {
                        $methodObject->addVariable($variableObject);
                        $variableObject = null;
                        $arrayObject = false;
                        $bracketCount = 0;

                    }
                }
                if ($functions && $bracketCount < 1 && $token->tokenEquals(')'))
                {
                    $functionEnd = true;
                }
                if ($functions && $functionEnd && $token->tokenEquals(':'))
                {
                    $methodReturn = true;
                }
                if ($functions && $token->tokenEquals('{') &&  $methodObject->hasName())
                {
                    $methodObject->setBody($this->getFunctionBody($methodObject, $sourceArray));

                    $this->getED()->dispatch($this->getED()->getEventName(self::class, 'parseDocumentMethodObjectPreAdd'), $event);

                    $methods->add($methodObject);
                    $comment = $modifier = $lastToken = $variableObject = $type = $methodObject = null;
                    $functionEnd = $methodReturn = $final = $functions = $valueDefinition = false;
                }
                if($functions && $variableObject instanceof Variable && $arrayObject && $token->tokenEquals('('))
                {
                    if($bracketCount > 0)
                    {
                        $variableArray[] = $token->getToken();
                    }
                    $bracketCount++;
                }
                if($functions && $variableObject instanceof Variable && $arrayObject && $token->tokenEquals(')'))
                {
                    $bracketCount--;
                    if(!empty($currentElement))
                    {
                        $variableArray[] = $currentElement;
                        $currentElement = [];
                    }
                    if($bracketCount === 0)
                    {
                        $variableObject->setDefaultValue($variableArray);
                        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'parseDocumentVariableObjectPreAddArray'), $event);
                        $variableObject->setType('array');
                        $methodObject->addVariable($variableObject);
                        $variableArray = [];
                        $bracketCount = 0;
                        $arrayObject = false;
                        $variableObject = null;
                    }
                    else
                    {
                        $variableArray[] = ')';
                    }
                }
                if($functions && $variableObject instanceof Variable && $token->tokenEquals('['))
                {
                    if(!$arrayObject)
                    {
                        $arrayObject = true;
                    }
                    if($bracketCount > 0)
                    {
                        if(count($currentElement) >= 1)
                        {
                            $currentElement[] = '[';
                            $variableArray[] = $currentElement;
                            $currentElement = [];
                        }
                        else
                        {
                            $variableArray[] = '[';
                        }
                    }
                    $bracketCount++;
                }
                if($functions && $variableObject instanceof Variable && $arrayObject && $token->tokenEquals(']'))
                {
                    $bracketCount--;
                    if(!empty($currentElement))
                    {
                        $variableArray[] = $currentElement;
                        $currentElement = [];
                    }
                    if($bracketCount === 0)
                    {
                        $variableObject->setDefaultValue($variableArray);
                        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'parseDocumentVariableObjectPreAddArray'), $event);
                        $methodObject->addVariable($variableObject);
                        $variableArray = [];
                        $bracketCount = 0;
                        $arrayObject = false;
                        $variableObject = null;
                    }
                    else
                    {
                        $variableArray[] = ']';
                    }
                }
                if($functionEnd && $functions)
                {
                    if($variableObject instanceof Variable)
                    {
                        $methodObject->addVariable($variableObject);
                    }
                    $variableArray = [];
                    $bracketCount = 0;
                    $arrayObject = false;
                    $variableObject = null;
                }
            }

            if (!$token->isWhiteSpace())
            {
                $lastToken = $token;
            }
        }

        return $methods->toArray();
    }

    /**
     * extract method Body from source File
     *
     * @param DocMethod $methodObject
     * @param array     $source
     *
     * @return array
     */
    protected function getFunctionBody(DocMethod $methodObject, array $source)
    {
        $body = new ArrayCollection();
        $event = (new PhpParserMethodsEvent())
            ->setSubject($this)
            ->setSource($source)
            ->setContent($body)
            ->setMethodObject($methodObject);

        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'getFunctionBodyPre'), $event);

        $bracket = 0;
        $method = false;
        $first = false;
        foreach ($event->getSource() as $row)
        {
            $check = strtolower($row);
            $check2 = str_replace(' ', '', $check);
            $search = $methodObject->getName() . '(';
            $search = strtolower($search);
            if (
                strpos($check, self::TYPE_FUNCTION) !== false
                && strpos($check2, $search) !== false
                && strpos($check, strtolower($methodObject->getVisibility())) !== false
            )
            {
                $method = true;
            }
            if ($method)
            {
                $bracket -= substr_count($row, '}');
                if ($bracket >= 1)
                {
                    $this->getED()->dispatch($this->getED()->getEventName(self::class, 'getFunctionBodyPreAdd'), $event);
                    $body->add($row);
                    $this->getED()->dispatch($this->getED()->getEventName(self::class, 'getFunctionBodyPostAdd'), $event);
                }
                $bracket += substr_count($row, '{');
                if (!$first && $bracket > 0)
                {
                    $first = true;
                }
                if ($bracket === 0 && $first === true)
                {
                    break;
                }
            }
        }

        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'getFunctionBodyPost'), $event);
        return $body->toArray();
    }
}
