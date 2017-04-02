<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class CodeGeneratorConstants
 *
 * @package   MjrOne\CodeGeneratorBundle\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class CodeGeneratorConstants
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
     * @return CodeGeneratorConstants
     */
    public function setName(string $name): CodeGeneratorConstants
    {
        $this->name = $name;

        return $this;
    }

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
     * @return CodeGeneratorConstants
     */
    public function setVisibility(string $visibility): CodeGeneratorConstants
    {
        $this->visibility = $visibility;

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
     * @return CodeGeneratorConstants
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
