<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Php\Parser\Document\Method as DocMethod;
use MjrOne\CodeGeneratorBundle\Php\Parser\Document\Variable;

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
                    $methodObject->setName(str_replace('$','',$text));
                    $methodObject->setFinal($final);
                    $functions = true;
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
                if($token === '{' && $functions)
                {
                    $this->getFunctionBody($methodObject);
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
     * @param DocMethod $methodObject
     */
    protected function getFunctionBody(DocMethod $methodObject)
    {
    }
}
