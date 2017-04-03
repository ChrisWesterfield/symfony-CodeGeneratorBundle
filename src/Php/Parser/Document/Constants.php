<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Parser\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class CodeGeneratorConstants
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Parser\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Constants
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
     * @return Constants
     */
    public function setName(string $name): Constants
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
     * @return Constants
     */
    public function setVisibility(string $visibility): Constants
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
     * @return Constants
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
