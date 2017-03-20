<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 13/03/2017
 * Time: 21:30
 */

namespace MjrOne\CodeGeneratorBundle\Services\Driver;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Document\Property;
use MjrOne\CodeGeneratorBundle\Event\MutatorGeneratorEvent;
use Symfony\Component\PropertyInfo\Type;

/**
 * Class MutatorGenerator
 *
 * @package MjrOne\CodeGeneratorBundle\Services\Driver
 */
class MutatorGenerator extends GeneratorAbstract implements GeneratorInterface
{
    const TEMPLATE = 'MjrOneCodeGeneratorBundle:Mutator:base.php.twig';
    const TRAITNAME = 'TraitMutator';

    const IGNORED = [
        'type',
        'ignore',
        'arrayType',
    ];
    const TYPE_OBJECT = 'object';
    const TYPE_INT = 'int';
    const TYPE_FLOAT = 'float';
    const TYPE_STRING = 'string';
    const TYPE_BOOL = 'bool';
    const TYPE_RESOURCE ='resource';
    const TYPE_ARRAY = 'array';
    const TYPE_CALLABLE = 'callable';
    const TYPE_NULL = 'null';
    const TYPE_MIXED = 'mixed';

    const ITERATABLE = [
        'array',
        '\Doctrine\Common\Collections\ArrayCollection',
        'ArrayCollection',
    ];
    const INTERNAL_TYPES = [
        self::TYPE_INT,
        self::TYPE_FLOAT,
        self::TYPE_STRING,
        self::TYPE_BOOL,
        self::TYPE_ARRAY,
        self::TYPE_MIXED
    ];

    /**
     * @return bool
     */
    public function process()
    {
        /** @var MutatorGeneratorEvent $event */
        $event = (new MutatorGeneratorEvent($this))->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.prepare'),$event);
        /** @var CG\Mutator\Mutator $classAnnotation */
        $classAnnotation = $this->getAnnotation();
        $event->setClass($classAnnotation);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.prepareClassAnnotations'),$event);
        $templateVars = [
            'properties' => [],
        ];
        $propertiesCollection = $this->getDocumentAnnotation()->getProperties();

        if(!empty($propertiesCollection))
        {
            foreach($propertiesCollection as $propertyItem)
            {
                $event->setPropertyItem($propertyItem);
                $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.setPropertyItem'),$event);
                /** @var Property $propertyItem */
                if(!empty($propertyItem))
                {
                    $propertyAnnotation = null;
                    foreach($propertyItem->getAnnotations() as $property)
                    {
                        if($property instanceof CG\PropertyInterface and $property instanceof CG\Mutator\Property)
                        {
                            $event->setPropertyAnnotation($property);
                            $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.setPropertyAnnotation'),$event);
                            $propertyAnnotation = $property;
                        }
                    }
                    if($propertyAnnotation === null && $classAnnotation->isIgnore())
                    {
                        continue;
                    }
                    else
                        if($propertyAnnotation === null)
                    {
                        $propertyAnnotation = new CG\Mutator\Property();
                        $event->setPropertyAnnotation($propertyAnnotation);
                        $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.setEmptyPropertyAnnotation'),$event);
                        $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.setPropertyAnnotation'),$event);
                    }
                    $propertyAnnotationArray = get_object_vars($propertyAnnotation);
                    $propertyKeys = array_keys($propertyAnnotationArray);
                    foreach($propertyKeys as $field)
                    {
                        if($propertyAnnotation->{$field}===null && !in_array($field,self::IGNORED,true))
                        {
                            $event->setField($field);
                            $event->setFieldValue($classAnnotation->{$field});
                            $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.getDefaultClassAnnotationValue'),$event);
                            $propertyAnnotation->{$field} = $event->getFieldValue();
                        }
                    }
                    $event->setFieldValue(null);
                    $event->setField(null);
                    $type = null;
                    /** @var Type $propertyType */
                    $propertyType = $propertyItem->getType();
                    if(!$propertyAnnotation->hasType())
                    {
                        if($propertyType === null)
                        {
                            $type = self::TYPE_MIXED;
                        }
                        else
                        {
                            $type = $propertyType->getBuiltinType();
                            if($propertyType->getBuiltinType() === self::TYPE_OBJECT)
                            {
                                $type = $propertyType->getClassName();
                            }
                            $propertyAnnotation->setType($type);
                            if($type === 'array' && $propertyType->getCollectionValueType() !== null)
                            {
                                $propertyAnnotation->setArrayType($propertyType->getCollectionValueType()->getBuiltinType());
                            }
                        }
                    }
                    if($propertyType instanceof Type && $propertyType->getBuiltinType() === self::TYPE_OBJECT)
                    {
                        $type = '\\'.ltrim($propertyAnnotation->getType(),'\\');
                        $event->setType($type);
                        $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.setEvent'),$event);
                        $propertyAnnotation->setType($event->getType());
                        $event->setType(null);
                    }
                    if($propertyAnnotation->getType() !== self::TYPE_BOOL || !$propertyAnnotation->isIs())
                    {
                        $propertyAnnotation->setIs(false);
                    }
                    if(!in_array($propertyAnnotation->getType(), self::ITERATABLE))
                    {
                        $propertyAnnotation->setIterator(false);
                    }
                    $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.preAddPropertyItem'),$event);
                    $propertyArray = [
                        'fieldName'=>$propertyItem->getField(),
                        'functionName'=>ucfirst($propertyItem->getField()),
                        'configuration'=>$propertyAnnotation->toArray(),
                    ];
                    $event->setPropertyArray($propertyArray);
                    $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.prepareAddArray'),$event);
                    $templateVars['properties'][] = $event->getPropertyArray();
                    $event->setPropertyArray(null);
                }
            }
        }
        $templateVars = $this->getBasics($templateVars, self::TRAITNAME);
        $event->setTemplateVariables($templateVars);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.preRender'),$event);
        $event->setContent($this->getRenderer()->renderTemplate(self::TEMPLATE,$templateVars));
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.renderedContent'),$event);
        $result = $this->getTraitFile($this->file, self::TRAITNAME);
        if(!empty($result))
        {
            $event->setTraitFileName($result);
            $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.fileAndPaths'),$event);
            list($path, $fileName) = $event->getTraitFileName();
            $this->writeToDisk($path, $fileName,$event->getContent());
            $this->getED()->dispatch($this->getED()->getEventName(self::class,'process.postStorage'),$event);
            $this->checkFileForTrait($templateVars);
        }
        return true;
    }

}
