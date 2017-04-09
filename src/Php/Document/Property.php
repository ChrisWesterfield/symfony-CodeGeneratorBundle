<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Document;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Php\Parser\AbstractParser;

/**
 * Class CodeGeneratorProperty
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Property Extends DocumentAbstract implements ParsedChildInterface
{
    /**
     * @var string|null
     */
    protected $comment;

    /**
     * @var string|null
     */
    protected $visibility;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $defaultValue;

    /**
     * @var bool
     */
    protected $nulled=false;

    /**
     * @var bool
     */
    protected $arrayValue=false;

    /**
     * @return bool
     */
    public function isNulled(): bool
    {
        return $this->nulled;
    }

    /**
     * @return Property
     */
    public function setNulled(): Property
    {
        $this->nulled = true;
        $this->updateFileContainer();

        return $this;
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     *
     * @return Property
     */
    public function setVisibility(string $visibility): Property
    {
        $this->visibility = $visibility;
        $this->updateFileContainer();

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Property
     */
    public function setName(string $name): Property
    {
        $this->name = $name;
        $this->updateFileContainer();

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed $defaultValue
     *
     * @return Property
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        $this->arrayValue = is_array($defaultValue)||$defaultValue instanceof ArrayCollection;
        $this->updateFileContainer();

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        if($this->comment === null && $this->isArrayValue())
        {
            switch($this->defaultValue)
            {
                case is_array($this->defaultValue):
                    $comment = AbstractParser::TYPE_ARRAY;
                break;
                case is_int($this->defaultValue):
                    $comment = AbstractParser::TYPE_INT;
                break;
                case is_float($this->defaultValue):
                    $comment = AbstractParser::TYPE_FLOAT;
                break;
                case (in_array($this->defaultValue,[AbstractParser::VALUE_FALSE, AbstractParser::VALUE_TRUE])):
                    $comment = AbstractParser::TYPE_BOOL;
                break;
                case is_string($this->defaultValue):
                    $comment = AbstractParser::TYPE_STRING;
                break;
                default:
                    $comment = AbstractParser::TYPE_MIXED;
                break;
            }
            $this->comment = '/**
     * @var array
     */ ';
        }
        return $this->comment;
    }

    /**
     * @param mixed $comment
     *
     * @return Property
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        $this->updateFileContainer();

        return $this;
    }

    /**
     * @return bool
     */
    public function hasDefaultValue():bool
    {
        return !empty($this->defaultValue);
    }

    /**
     * @return bool
     */
    public function hasComment():bool
    {
        return !empty($this->comment);
    }

    /**
     * @return bool
     */
    public function isArrayValue(): bool
    {
        return $this->arrayValue;
    }
}
