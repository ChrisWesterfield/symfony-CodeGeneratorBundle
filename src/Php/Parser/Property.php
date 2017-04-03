<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Php\Parser\Document\Property as DocProperty;

/**
 * Class Property
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Parser
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Property
{
    public const VAR_PRIVATE = 'private';
    public const VAR_PROTECTED = 'protected';
    public const VAR_PUBLIC  = 'public';
    public const VAR_ALLOWED = [
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
        $properties = [];
        $propertyPrototype = new DocProperty();
        $propertyObject = $propertyText = $property = $lastItem = null;
        $equals = false;
        foreach($tokens as $token)
        {
            if(!is_string($token))
            {
                list($id, $text) = $token;
                $id = (int)$id;
                if($id === T_DOC_COMMENT)
                {
                    $propertyText = $text;
                }
                if($id === T_VARIABLE)
                {
                    list($lId, $lText) = $lastItem;
                    $lId = (int)$lId;
                    $propertyObject = clone $propertyPrototype;
                    if(in_array($lId, self::VAR_ALLOWED))
                    {
                        switch($lId)
                        {
                            case T_PUBLIC:
                                $propertyObject->setVisibility(self::VAR_PUBLIC);
                            break;
                            case T_PROTECTED:
                                $propertyObject->setVisibility(self::VAR_PROTECTED);
                            break;
                            case T_PRIVATE:
                                $propertyObject->setVisibility(self::VAR_PRIVATE);
                            break;
                        }
                    }
                    $propertyObject->setComment($propertyText);
                    $propertyObject->setName(str_replace('$','',$text));
                }
                if($propertyObject instanceof DocProperty && $equals)
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
                    $propertyObject->setDefaultValue($value);
                }
                if($id!==T_WHITESPACE)
                {
                    $lastItem = $token;
                }
            }
            else
            {
                if($token === '=')
                {
                    $equals = true;
                }
                else
                {
                    if($propertyObject instanceof DocProperty)
                    {
                        $properties[] = $propertyObject;
                    }
                    $propertyObject = $propertyText = $property = $lastItem = null;
                    $equals = false;
                }
            }
        }

        return $properties;
    }
}
