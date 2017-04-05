<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
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
class Constants
{
    public const CONST_PRIVATE = 'private';
    public const CONST_PROTECTED = 'protected';
    public const CONST_PUBLIC  = 'public';
    public const CONST_STRING = 'const';
    public const CONST_ALLOWED = [
        T_PUBLIC,
        T_PRIVATE,
        T_PROTECTED,
    ];

    /**
     * @param string $source
     * @param array  $tokens
     * @param string $className
     *
     * @return array ;
     */
    public  function parseDocument(string $source,array $tokens, string $className)
    {
        $constants = [];
        $lastItem = $constObject = null;
        $constPrototype = new DocConstants();
        $equals = $constItem = false;
        foreach($tokens as $token)
        {
            if (!is_string($token))
            {
                list($id, $text) = $token;
                $id = (int)$id;
                if($id === T_CONST)
                {
                    $constItem = true;
                    $constObject = clone $constPrototype;
                    if(!is_string($lastItem))
                    {
                        $constObject->setVisibility(self::CONST_PUBLIC);
                        list($lId, $lText) = $lastItem;
                        $lId = (int)$lId;
                        if(in_array($lId, self::CONST_ALLOWED))
                        {
                            switch($lId)
                            {
                                case T_PUBLIC:
                                    $constObject->setVisibility(self::CONST_PUBLIC);
                                break;
                                case T_PROTECTED:
                                    $constObject->setVisibility(self::CONST_PROTECTED);
                                break;
                                case T_PRIVATE:
                                    $constObject->setVisibility(self::CONST_PRIVATE);
                                break;
                            }
                        }
                    }
                }
                else
                    if($id === T_STRING && $constItem && $constObject instanceof Constants)
                {
                    /** @var DocConstants $constObject */
                    $constObject->setName(trim($text));
                }
                if($constObject instanceof Constants && $constObject->hasName() && $constItem && $equals && $id !== T_WHITESPACE)
                {
                    if(in_array($constObject->getVisibility(),[self::CONST_PRIVATE, self::CONST_PROTECTED]))
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
                    }
                    else
                    {
                        $constName = $constObject->getName();
                        $value = constant("$className::$constName");
                    }
                    $constObject->setValue($value);
                    $constObject->resetUpdateNeeded();
                    $constants[] = $constObject;
                    $constObject = null;
                    $equals = $constItem = false;
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
            }
        }
        return $constants;
    }
}
