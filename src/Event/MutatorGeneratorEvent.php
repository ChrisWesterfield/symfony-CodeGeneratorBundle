<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 18/03/2017
 * Time: 02:17
 */

namespace MjrOne\CodeGeneratorBundle\Event;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Document\Property;

class MutatorGeneratorEvent extends EventAbstract
{
    /**
     * @var Property
     */
    protected $propertyItem;
    /**
     * @var CG\Mutator\Property
     */
    protected $propertyAnnotation;
    /**
     * @var string
     */
    protected $content;
    /**
     * @var array
     */
    protected $traitFileName;

    /**
     * @var string
     */
    protected $field;

    /**
     * @var CG\ClassInterface
     */
    protected $class;

    /**
     * @var mixed
     */
    protected $fieldValue;

    /**
     * @var  string
     */
    protected $type;

    /**
     * @var array
     */
    protected $propertyArray;

    /**
     * @var array
     */
    protected $templateVariables;

    /**
     * @return Property
     */
    public function getPropertyItem(): Property
    {
        return $this->propertyItem;
    }

    /**
     * @param Property $propertyItem
     *
     * @return MutatorGeneratorEvent
     */
    public function setPropertyItem(Property $propertyItem): MutatorGeneratorEvent
    {
        $this->propertyItem = $propertyItem;

        return $this;
    }

    /**
     * @return CG\Mutator\Property
     */
    public function getPropertyAnnotation(): CG\Mutator\Property
    {
        return $this->propertyAnnotation;
    }

    /**
     * @param CG\Mutator\Property $propertyAnnotation
     *
     * @return MutatorGeneratorEvent
     */
    public function setPropertyAnnotation(CG\Mutator\Property $propertyAnnotation
    ): MutatorGeneratorEvent
    {
        $this->propertyAnnotation = $propertyAnnotation;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return MutatorGeneratorEvent
     */
    public function setContent(string $content): MutatorGeneratorEvent
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return array
     */
    public function getTraitFileName(): array
    {
        return $this->traitFileName;
    }

    /**
     * @param array $traitFileName
     *
     * @return MutatorGeneratorEvent
     */
    public function setTraitFileName(array $traitFileName): MutatorGeneratorEvent
    {
        $this->traitFileName = $traitFileName;

        return $this;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     *
     * @return MutatorGeneratorEvent
     */
    public function setField(string $field=null): MutatorGeneratorEvent
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return CG\ClassInterface
     */
    public function getClass(): CG\ClassInterface
    {
        return $this->class;
    }

    /**
     * @param CG\ClassInterface $class
     *
     * @return MutatorGeneratorEvent
     */
    public function setClass(CG\ClassInterface $class): MutatorGeneratorEvent
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFieldValue()
    {
        return $this->fieldValue;
    }

    /**
     * @param mixed $fieldValue
     *
     * @return MutatorGeneratorEvent
     */
    public function setFieldValue($fieldValue)
    {
        $this->fieldValue = $fieldValue;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return MutatorGeneratorEvent
     */
    public function setType(string $type=null): MutatorGeneratorEvent
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array
     */
    public function getPropertyArray(): array
    {
        return $this->propertyArray;
    }

    /**
     * @param array $propertyArray
     *
     * @return MutatorGeneratorEvent
     */
    public function setPropertyArray(array $propertyArray=null): MutatorGeneratorEvent
    {
        $this->propertyArray = $propertyArray;

        return $this;
    }

    /**
     * @return array
     */
    public function getTemplateVariables(): array
    {
        return $this->templateVariables;
    }

    /**
     * @param array $templateVariables
     *
     * @return MutatorGeneratorEvent
     */
    public function setTemplateVariables(array $templateVariables): MutatorGeneratorEvent
    {
        $this->templateVariables = $templateVariables;

        return $this;
    }
}
