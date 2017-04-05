<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Exception\TestClassDoesNotExistException;
use MjrOne\CodeGeneratorBundle\Php\Document\File as DocFile;

/**
 * Class File
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Parser
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class File
{
    /**
     * @var Constants
     */
    protected $constants;

    /**
     * @var Method
     */
    protected $methods;

    /**
     * @var Property
     */
    protected $property;

    protected $fileContainer;

    /**
     * File constructor.
     */
    public function __construct()
    {
        $this->constants = new Constants();
        $this->methods = new Method();
        $this->property = new Property();
    }

    public function readFile($file)
    {
        if(!file_exists($file))
        {
            throw new TestClassDoesNotExistException('Test Class '.$file.' does not exist');
        }
        $content = file_get_contents($file);
        $tokens = token_get_all($content);
        return $this->parseDocument($content, $tokens);
    }

    /**
     * @param string           $source
     * @param array            $tokens
     * @param \ReflectionClass $reflectionClass
     *
     * @return \MjrOne\CodeGeneratorBundle\Php\Document\File
     */
    protected function parseDocument(string $source,array $tokens)
    {
        $fileContainer = new DocFile();
        $this->getDeclarStrict($tokens, $fileContainer);
        $this->getNamespaceDeclaration($tokens, $fileContainer);
        $this->getUsedClasses($tokens,$fileContainer);
        $this->getClassHeaders($tokens,$fileContainer);
        $fileContainer->setConstants((new Constants())->parseDocument($source, $tokens, $fileContainer->getNamespace().'\\'.$fileContainer->getClassName()));
        $fileContainer->setMethods((new Method())->parseDocument($source, $tokens));
        $fileContainer->setProperties((new Property())->parseDocument($source, $tokens));
        $fileContainer->resetUpdateNeeded();
        return $fileContainer;
    }

    /**
     * @param array $tokens
     * @param DocFile  $fileContainer
     *
     * @return bool
     */
    public function getClassHeaders(array $tokens, DocFile $fileContainer)
    {
        $abstract = $class = $extends = $implements = $useBool = $classBody = false;
        $classComment = '';
        $implementsArray = $classUse = [];
        foreach($tokens as $token)
        {
            if (!is_string($token))
            {
                list($id, $text) = $token;
                $id = (int)$id;
                if($id === T_DOC_COMMENT)
                {
                    $classComment = $text;
                }
                if($id === T_ABSTRACT)
                {
                    $abstract = true;
                }
                if($id === T_CLASS)
                {
                    $fileContainer->setClassComment($classComment);
                    if($abstract)
                    {
                        $fileContainer->setAbstractClass(true);
                    }
                    $class = true;
                }
                if($class && $id === T_STRING)
                {
                    $fileContainer->setClassName($text);
                    $class = false;
                }
                if($id === T_EXTENDS)
                {
                    $extends = true;
                }
                if($extends && $id === T_STRING)
                {
                    $fileContainer->setExtends($text);
                    $extends = false;
                }
                if($id === T_IMPLEMENTS)
                {
                    $implements = true;
                }
                if($implements && $id === T_STRING)
                {
                    $implementsArray[] = $text;
                }
                if($classBody)
                {
                    if($id === T_USE)
                    {
                        $useBool = true;
                    }
                    if($useBool && $id === T_STRING)
                    {
                        $classUse[] = $text;
                    }
                }
            }
            else
            {
                if($token === '{')
                {
                    $implements = false;
                    $fileContainer->setInterfaces($implementsArray);
                    $classBody = true;
                }
                if($token === ';' && $classBody && $useBool)
                {
                    $useBool = false;
                }
            }
        }
        return false;
    }

    /**
     * @param array $tokens
     * @param DocFile  $fileContainer
     *
     * @return bool
     */
    protected function getUsedClasses(array $tokens, DocFile $fileContainer)
    {
        $useClasses = false;
        $useRow = '';
        $useArray = [];
        $useBool = false;
        foreach($tokens as $token)
        {
            if(!is_string($token))
            {
                list($id, $text) = $token;
                $id = (int)$id;
                if($id === T_USE)
                {
                    $useBool = true;
                }
                if($useBool && in_array($id, [T_STRING, T_NS_SEPARATOR]))
                {
                    $useRow .= $text;
                }
                if($id === T_CLASS)
                {
                    break;
                }
            }
            else
                if($token === ';' && !empty($useRow))
            {
                $useArray[] = $useRow;
                $useRow = '';
                $useBool = false;
            }
        }
        if(!empty($useArray))
        {
            $fileContainer->setUsedNamespaces($useArray);
            return true;
        }
        return false;
    }

    /**
     * @param array $tokens
     * @param DocFile  $fileContainer
     *
     * @return bool
     */
    protected function getNamespaceDeclaration(array $tokens, DocFile $fileContainer)
    {
        $fullNameSpace = '';
        $namespace = false;
        foreach($tokens as $token)
        {
            if(!is_string($token))
            {
                list($id, $text) = $token;
                $id = (int)$id;
                if($id === T_NAMESPACE)
                {
                    $namespace = true;
                }
                if($namespace && in_array($id, [T_STRING, T_NS_SEPARATOR]))
                {
                    $fullNameSpace .= $text;
                }
            }
            else
            {
                if($namespace && $token===';')
                {
                    break;
                }
            }
        }
        if(!empty($fullNameSpace))
        {
            $fileContainer->setNamespace($fullNameSpace);
            return true;
        }
        return false;
    }

    /**
     * @param array $tokens
     * @param DocFile  $fileContainer
     *
     * @return bool
     */
    protected function getDeclarStrict(array $tokens, DocFile $fileContainer)
    {
        $tokenStart = false;
        $strictType=false;
        foreach($tokens as $token)
        {
            if(!is_string($token))
            {
                list($id, $text) = $token;
                $id = (int)$id;
                if($id === T_DECLARE)
                {
                    $tokenStart = true;
                }
                if($tokenStart && $id === T_STRING && $text === 'strict_types')
                {
                    $strictType = true;
                }
                if($tokenStart && $strictType && $id === T_LNUMBER && $text === '1')
                {
                    $fileContainer->setStrict(true);
                    return true;
                }
            }
        }

        return false;
    }
}
