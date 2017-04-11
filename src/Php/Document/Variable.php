<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Php\Document;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;

/**
 * Class Variable
 *
 * @package   MjrOne\CodeGeneratorBundle\Php\Document
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Variable Extends DocumentAbstract
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|false
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $defaultValue;

    /**
     * @var bool
     */
    protected $nulled=false;

    /**
     * @return bool
     */
    public function isNulled(): bool
    {
        return $this->nulled;
    }

    /**
     * @param bool $nulled
     *
     * @return Variable
     */
    public function setNulled(bool $nulled): Variable
    {
        $this->nulled = $nulled;

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
     * @return Variable
     */
    public function setName(string $name): Variable
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return false|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param false|string $type
     *
     * @return Variable
     */
    public function setType($type)
    {
        $this->type = $type;

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
     * @return Variable
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function hasDefaultValue()
    {
        return !empty($this->defaultValue);
    }
}
