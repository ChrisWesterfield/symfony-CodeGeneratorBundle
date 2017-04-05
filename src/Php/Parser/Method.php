<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
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
class Method
{
    public const METHOD_PRIVATE = 'private';
    public const METHOD_PROTECTED = 'protected';
    public const METHOD_PUBLIC  = 'public';
    public const METHOD_ALLOWED = [
        T_PUBLIC,
        T_PRIVATE,
        T_PROTECTED,
    ];
    /**
     * @param string $source
     * @param array  $tokens
     *
     *  @return array;
     */
    public  function parseDocument(string $source,array $tokens)
    {
        $sourceArray = explode("\n",$source);
        $methods = [];
        $methodPrototype = new DocMethod();
        $variablePrototype = new Variable();
        $comment = $modifier = $lastItem = $variableObject = $type = $methodObject = null;
        $final = $functions = $valueDefinition = $type = false;
        foreach($tokens as $token)
        {
            if(!is_string($token))
            {
                list($id, $text) = $token;
                $id = (int)$id;
                if($id===T_FINAL)
                {
                    $final = true;
                }
                if($id === T_DOC_COMMENT)
                {
                    $comment = $text;
                }
                if($id === T_FUNCTION)
                {
                    list($lId, $lText) = $lastItem;
                    $lId = (int)$lId;
                    $methodObject = clone $methodPrototype;
                    if(in_array($lId, self::METHOD_ALLOWED))
                    {
                        switch($lId)
                        {
                            case T_PUBLIC:
                                $methodObject->setVisibility(self::METHOD_PUBLIC);
                                break;
                            case T_PROTECTED:
                                $methodObject->setVisibility(self::METHOD_PROTECTED);
                                break;
                            case T_PRIVATE:
                                $methodObject->setVisibility(self::METHOD_PRIVATE);
                                break;
                        }
                    }
                    $methodObject->setComment(explode("\n",$comment));
                    $methodObject->setFinal($final);
                    $functions = true;
                }
                if($functions === true && !$methodObject->hasName() && $id === T_STRING)
                {
                    $methodObject->setName(str_replace('$','',$text));
                }
                if($functions && $id === T_STRING)
                {
                    $type = $text;
                }
                if($functions && $id === T_VARIABLE)
                {
                    $variableObject = clone $variablePrototype;
                    $variableObject->setName(str_replace('$','',$text));
                    if($type !== null)
                    {
                        $variableObject->setType($type);
                    }
                    $valueDefinition = true;
                }
                if($functions && $valueDefinition)
                {

                    $value = null;
                    switch($id)
                    {
                        case T_DNUMBER:
                            $value = (double)$text;
                        break;
                        case T_LNUMBER:
                            $value = (int)$text;
                        break;
                        case T_STRING:
                            if($text === 'true')
                            {
                                $value = true;
                            }
                            else
                                if($text === 'false')
                            {
                                $value = false;
                            }
                            else
                            {
                                $value = '\''.(string)$text.'\'';
                            }
                        break;
                    }
                    $variableObject->setDefaultValue($value);
                }

                if($id!==T_WHITESPACE)
                {
                    $lastItem = $token;
                }
            }
            else
            {
                if($token === ',' && $functions && $valueDefinition && $variableObject instanceof Variable)
                {
                    $methodObject->addVariable($variableObject);
                }
                if($token === '{' && $functions && $methodObject->hasName())
                {
                    $methodObject->setBody($this->getFunctionBody($methodObject, $sourceArray));
                    $methodObject->resetUpdateNeeded();
                    $methods[] = $methodObject;
                    $comment = $modifier = $lastItem = $variableObject = $type = $methodObject = null;
                    $final = $functions = $valueDefinition = $type = false;
                }
            }
        }

        return $methods;
    }

    /**
     * extract method Body from source File
     *
     * @param DocMethod $methodObject
     *
     * @return array
     */
    protected function getFunctionBody(DocMethod $methodObject,array $source)
    {
        $body = [];
        $bracket = 0;
        $method = false;
        $first = false;
        foreach($source as $row)
        {
            $check = strtolower($row);
            $check2 = str_replace(' ', '', $check);
            $search = $methodObject->getName().'(';
            $search = strtolower($search);
            if(
                strpos($check, strtolower($methodObject->getVisibility()))!==false
                &&
                strpos($check, 'function') !== false
                &&
                strpos($check2, $search) !==false
            )
            {
                $method = true;
            }
            if($method)
            {
                $bracket -= substr_count($row, '}');
                if($bracket >= 1)
                {
                    $body[] = $row;
                }
                $bracket += substr_count($row, '{');
                if(!$first && $bracket > 0)
                {
                    $first = true;
                }
                if($bracket === 0 && $first === true)
                {
                    break;
                }
            }
        }
        return $body;
    }
}
