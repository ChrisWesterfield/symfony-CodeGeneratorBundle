<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class CodeGeneratorProperty
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Parser\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Property
{
    /**
     * @var string|null
     */
    protected $comment;

    /**
     * @var string
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
     * @return string
     */
    public function getVisibility(): string
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

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
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

        return $this;
    }
}
