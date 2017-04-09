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
        $methods = [];
        $methodPrototype = new DocMethod();
        $variablePrototype = new Variable();
        $comment = $modifier = $lastToken = $variableObject = $type = $methodObject = null;
        $functionEnd = $methodReturn = $final = $functions = $valueDefinition = false;
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
                    $methodObject->setVisibility($this->getModifier($lastToken));
                    $comment = explode("\n",$comment);
                    $newComment = [];
                    foreach($comment as $com)
                    {
                        $newComment[] = str_replace('     *      *', '     *', $com);
                    }
                    $methodObject->setComment($newComment);
                    $methodObject->setFinal($final);
                    $functions = true;
                }
                if ($functions === true && !$methodObject->hasName() && $token->isString())
                {
                    $methodObject->setName($token->getName());
                }
                if ($functions && $token->isString())
                {
                    $type = $token->getText();
                }
                if ($functions && $token->isVariable())
                {
                    $variableObject = clone $variablePrototype;
                    $variableObject->setName(str_replace('$', '', $token->getText()));
                    if ($type !== null && $type !== 'false')
                    {
                        $variableObject->setType($type);
                    }
                    $valueDefinition = true;
                }
                if ($functions && $valueDefinition && !$token->isVariable() && $variableObject instanceof Variable)
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
                    $methodObject->addVariable($variableObject);
                    $variableObject = null;
                }

                if ($functions && $functionEnd && $methodReturn && $token->isString())
                {
                    $methodObject->setMethodReturn($token->getText());
                    $functionEnd = false;
                    $methodReturn = false;
                }

                if (!$token->isWhiteSpace())
                {
                    $lastToken = $token;
                }
            }
            else
            {
                if ($functions && $token->tokenEquals(')'))
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
                    $methods[] = $methodObject;
                    $comment = $modifier = $lastToken = $variableObject = $type = $methodObject = null;
                    $functionEnd = $methodReturn = $final = $functions = $valueDefinition = false;
                }
            }
        }

        return $methods;
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
        $body = [];
        $bracket = 0;
        $method = false;
        $first = false;
        foreach ($source as $row)
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
                    $body[] = $row;
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

        return $body;
    }
}
