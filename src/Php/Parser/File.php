<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Event\PhpParserFileEvent;
use MjrOne\CodeGeneratorBundle\Exception\TestClassDoesNotExistException;
use MjrOne\CodeGeneratorBundle\Php\Document\File as DocFile;
use MjrOne\CodeGeneratorBundle\Php\Document\ParsedChildInterface;
use MjrOne\CodeGeneratorBundle\Services\EventDispatcherService;

/**
 * Class File
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Parser
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class File extends AbstractParser
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

    /**
     * File constructor.
     * @param EventDispatcherService $eventDispatcher
     * @param Constants $constants
     * @param Method $method
     * @param Property $property
     */
    public function __construct(EventDispatcherService $eventDispatcher, Constants $constants, Method $method, Property $property)
    {
        parent::__construct($eventDispatcher);
        $this->constants = $constants;
        $this->methods = $method;
        $this->property = $property;
    }

    public function readFile($file)
    {
        if (!file_exists($file)) {
            throw new TestClassDoesNotExistException('Test Class ' . $file . ' does not exist');
        }
        $content = file_get_contents($file);
        $tokens = token_get_all($content);
        return $this->parseDocument($content, $tokens);
    }

    /**
     * @param string $source
     * @param array $tokens
     * @param \ReflectionClass $reflectionClass
     *
     * @return \MjrOne\CodeGeneratorBundle\Php\Document\File
     */
    protected function parseDocument(string $source, array $tokens)
    {
        $fileContainer = new DocFile();
        $event = (new PhpParserFileEvent())->setSubject($this)->setTokens($tokens)->setSource($source)->setFileObject($fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'ParseDocumentPre'),$event);
        $this->getDeclarStrict($tokens, $fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'ParseDocumentPostDeclareStrict'),$event);
        $this->getNamespaceDeclaration($tokens, $fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'ParseDocumentPostNamespace'),$event);
        $this->getUsedClasses($tokens, $fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'ParseDocumentPostUsedClasses'),$event);
        $this->getClassHeaders($tokens, $fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'ParseDocumentPostClassHeaders'),$event);
        $this->getClassTraits($tokens, $fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'ParseDocumentPostTraits'),$event);
        /** @var \MjrOne\CodeGeneratorBundle\Php\Document\Constants[] $constants */
        $this->addObject($this->constants->parseDocument($source, $tokens, $fileContainer->getNamespace() . '\\' . $fileContainer->getClassName()),$fileContainer,'addConstant');
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'ParseDocumentPostConstants'),$event);
        $this->addObject($this->methods->parseDocument($source, $tokens),$fileContainer,'addMethod');
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'ParseDocumentPostMethods'),$event);
        $this->addObject($this->property->parseDocument($source, $tokens),$fileContainer,'addProperty');
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'ParseDocumentPostProperty'),$event);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'ParseDocumentPreReturn'),$event);
        return $fileContainer;
    }

    /**
     * @param array $objects
     * @param DocFile $file
     * @param string $addMethod
     * @return void
     */
    protected function addObject(array $objects, DocFile $file, string $addMethod):void
    {
        if(!empty($objects))
        {
            foreach($objects as $object)
            {
                $object->setParent($file);
                $file->$addMethod($object);
            }
        }
    }

    /**
     * @param array $tokens
     * @param DocFile $fileContainer
     *
     * @return bool
     */
    public function getClassHeaders(array $tokens, DocFile $fileContainer)
    {
        $abstract = $class = $extends = $implements = $useBool = $classBody = false;
        $classComment = '';
        $implementsArray = $classUse = [];
        $event = (new PhpParserFileEvent())->setSubject($this)->setTokens($tokens)->setFileObject($fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'getClassHeaders'),$event);
        $tokens = $event->getTokens();
        foreach ($tokens as $tokenRaw) {
            $token = new Token($tokenRaw);
            if (!$token->isStringToken()) {
                if ($token->isDocComment()) {
                    $classComment = $token->getText();
                }
                if ($token->isAbstract()) {
                    $abstract = true;
                }
                if ($token->isClass()) {
                    $fileContainer->setClassComment($classComment);
                    if ($abstract) {
                        $fileContainer->setAbstractClass(true);
                    }
                    $class = true;
                }
                if ($class && $token->isString()) {
                    $fileContainer->setClassName($token->getText());
                    $class = false;
                }
                if ($token->isExtends()) {
                    $extends = true;
                }
                if ($extends && $token->isString()) {
                    $fileContainer->setExtends($token->getText());
                    $extends = false;
                }
                if ($token->isImplements()) {
                    $implements = true;
                }
                if ($implements && $token->isString()) {
                    $implementsArray[] = $token->getText();
                }
                if ($classBody) {
                    if ($token->isUse()) {
                        $useBool = true;
                    }
                    if ($useBool && $token->isString()) {
                        $classUse[] = $token->getText();
                    }
                }
            } else {
                if ($token->tokenEquals('{')) {
                    $implements = false;
                    $fileContainer->setInterfaces($implementsArray);
                    $classBody = true;
                }
                if ($token->tokenEquals(';') && $classBody && $useBool) {
                    $useBool = false;
                }
            }
        }
        return false;
    }

    /**
     * @param array $tokens
     * @param DocFile $fileContainer
     *
     * @return bool
     */
    protected function getUsedClasses(array $tokens, DocFile $fileContainer)
    {
        $useClasses = false;
        $useRow = '';
        $useArray = [];
        $useBool = false;
        $event = (new PhpParserFileEvent())->setSubject($this)->setTokens($tokens)->setFileObject($fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'getUsedClassesPre'),$event);
        $tokens = $event->getTokens();
        foreach ($tokens as $tokenRaw) {
            $token = new Token($tokenRaw);
            if (!$token->isStringToken()) {
                if ($token->isUse()) {
                    $useBool = true;
                }
                if ($useBool && $token->isNameSpaceElement()) {
                    $useRow .= $token->getText();
                }
                if($useBool && $token->isAs())
                {
                    $useRow .= ' as ';
                }
                if ($token->isClass()) {
                    break;
                }
            } else
                if ($token->tokenEquals(';') && !empty($useRow)) {
                    $useArray[] = $useRow;
                    $useRow = '';
                    $useBool = false;
                }
        }
        if (!empty($useArray)) {
            $fileContainer->setUsedNamespaces($useArray);
            $event = (new PhpParserFileEvent())->setSubject($this)->setTokens($tokens)->setFileObject($fileContainer);
            $this->getED()->dispatch($this->getED()->getEventName(self::class,'getUsedClassesPost'),$event);
            return true;
        }
        return false;
    }

    /**
     * @param array $tokens
     * @param DocFile $fileContainer
     *
     * @return bool
     */
    protected function getNamespaceDeclaration(array $tokens, DocFile $fileContainer)
    {
        $fullNameSpace = '';
        $namespace = false;
        $event = (new PhpParserFileEvent())->setSubject($this)->setTokens($tokens)->setFileObject($fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'getNamesoaceDeclarationPre'),$event);
        $tokens = $event->getTokens();
        foreach ($tokens as $tokenRaw) {
            $token = new Token($tokenRaw);
            if (!$token->isStringToken()) {
                if ($token->isNamespace()) {
                    $namespace = true;
                }
                if ($namespace && $token->isNameSpaceElement()) {
                    $fullNameSpace .= $token->getText();
                }
            } else {
                if ($namespace && $token->tokenEquals(';')) {
                    break;
                }
            }
        }
        if (!empty($fullNameSpace)) {
            $fileContainer->setNamespace($fullNameSpace);
            $event = (new PhpParserFileEvent())->setSubject($this)->setTokens($tokens)->setFileObject($fileContainer);
            $this->getED()->dispatch($this->getED()->getEventName(self::class,'getNamesoaceDeclarationPost'),$event);
            return true;
        }
        return false;
    }

    /**
     * @param array $tokens
     * @param DocFile $fileContainer
     *
     * @return bool
     */
    protected function getDeclarStrict(array $tokens, DocFile $fileContainer)
    {
        $tokenStart = false;
        $strictType = false;
        $event = (new PhpParserFileEvent())->setSubject($this)->setTokens($tokens)->setFileObject($fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'getDeclarStrictPre'),$event);
        $tokens = $event->getTokens();
        foreach ($tokens as $tokenRaw) {
            $token = new Token($tokenRaw);
            if (!$token->isStringToken()) {
                if ($token->isDeclare()) {
                    $tokenStart = true;
                }
                if ($tokenStart && $token->isString() && $token->equalsText(self::TYPE_STRICT)) {
                    $strictType = true;
                }
                if ($tokenStart && $strictType && $token->isInteger() && $token->equalsText('1')) {
                    $fileContainer->setStrict(true);
                    $event = (new PhpParserFileEvent())->setSubject($this)->setTokens($tokens)->setFileObject($fileContainer);
                    $this->getED()->dispatch($this->getED()->getEventName(self::class,'getDeclarStrictPost'),$event);
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param array $tokens
     * @param DocFile $fileContainer
     */
    protected function getClassTraits(array $tokens, DocFile $fileContainer)
    {
        $bracket = $class = $use = false;
        $namespace = null;
        $trait = null;
        $event = (new PhpParserFileEvent())->setSubject($this)->setTokens($tokens)->setFileObject($fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'getClassTraitsPre'),$event);
        $tokens = $event->getTokens();
        foreach($tokens as $tokenRaw)
        {
            $token = new Token($tokenRaw);
            if(!$class && !$token->isStringToken() && $token->isClass())
            {
                $class = true;
            }
            if(!$bracket && $class && $token->isStringToken() && $token->getToken() === '{')
            {
                $bracket = true;
            }
            if($class && $bracket && !$token->isStringToken() && $token->isUse())
            {
                $use = true;
            }
            if($class && $bracket && $use && !$token->isStringToken() && $token->isNamespaceSeperator())
            {
                $namespace .= (string)'\\';
            }
            if($class && $bracket && $use && !$token->isStringToken() && $token->isString())
            {
                $namespace .= $token->getText();
                $trait = $token->getText();
            }
            if($class && $bracket && $use && $token->isStringToken() && $token->getToken() === ';')
            {
                if(!$fileContainer->hasTraitUse($namespace) && !empty($trait))
                {
                    if(!$fileContainer->hasUsedNamespace(ltrim($namespace,'\\')))
                    {
                        $fileContainer->addUsedNamespace(ltrim($namespace,'\\'));
                    }
                    $fileContainer->addTraitUse($trait);
                    $event = (new PhpParserFileEvent())->setSubject($this)->setTokens($tokens)->setFileObject($fileContainer);
                    $this->getED()->dispatch($this->getED()->getEventName(self::class,'getClassTraitsPostAdd'),$event);
                }
                $namespace = $trait = '';
                $use = false;
            }
        }
        $event = (new PhpParserFileEvent())->setSubject($this)->setTokens($tokens)->setFileObject($fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'getClassTraitsPost'),$event);
    }
}
