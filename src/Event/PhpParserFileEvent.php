<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Php\Document\File as FileObject;
use MjrOne\CodeGeneratorBundle\Php\Parser\File;
use MjrOne\CodeGeneratorBundle\Php\Parser\Token;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class PhpParserConstantEvent
 * @package MjrOne\CodeGeneratorBundle\Event
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class PhpParserFileEvent extends Event
{
    /**
     * @var File
     */
    protected $subject;

    /**
     * @var array
     */
    protected $tokens;

    /**
     * @var string
     */
    public $source;

    /**
     * @var Token
     */
    protected $token;

    /**
     * @var FileObject
     */
    protected $fileObject;

    /**
     * @return File
     */
    public function getSubject(): File
    {
        return $this->subject;
    }

    /**
     * @param File $subject
     * @return PhpParserFileEvent
     */
    public function setSubject(File $subject): PhpParserFileEvent
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return array
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * @param array $tokens
     * @return PhpParserFileEvent
     */
    public function setTokens(array $tokens): PhpParserFileEvent
    {
        $this->tokens = $tokens;
        return $this;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return PhpParserFileEvent
     */
    public function setSource(string $source): PhpParserFileEvent
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return Token
     */
    public function getToken(): Token
    {
        return $this->token;
    }

    /**
     * @param Token $token
     * @return PhpParserFileEvent
     */
    public function setToken(Token $token): PhpParserFileEvent
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return FileObject
     */
    public function getFileObject(): FileObject
    {
        return $this->fileObject;
    }

    /**
     * @param FileObject $fileObject
     * @return PhpParserFileEvent
     */
    public function setFileObject(FileObject $fileObject): PhpParserFileEvent
    {
        $this->fileObject = $fileObject;
        return $this;
    }
}