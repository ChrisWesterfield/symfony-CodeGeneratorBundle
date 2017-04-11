<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class CodeGeneratorConstants
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Constants Extends DocumentAbstract implements ParsedChildInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $visibility;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var bool
     */
    protected $arrayValue=false;

    /**
     * @return bool
     */
    public function isArrayValue(): bool
    {
        return $this->arrayValue;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function hasName()
    {
        return !empty($this->name);
    }

    /**
     * @param string $name
     *
     * @return Constants
     */
    public function setName(string $name): Constants
    {
        $this->name = $name;
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
     * @return Constants
     */
    public function setVisibility(string $visibility): Constants
    {
        $this->visibility = $visibility;
        $this->updateFileContainer();

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return Constants
     */
    public function setValue($value)
    {
        $this->value = $value;
        $this->arrayValue = is_array($value);
        $this->updateFileContainer();

        return $this;
    }
}
