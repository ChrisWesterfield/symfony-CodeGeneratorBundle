<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Driver;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Document\UnitObject;
use MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit\UnitGenerator;
use MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit\UnitTestInterface;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorDriverInterface;
use Zend\Code\Generator\GeneratorInterface;

/**
 * Class PhpUnitCodeGeneratorService
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Driver
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 */
class PhpUnitCodeGeneratorService extends GeneratorAbstract implements GeneratorInterface, GeneratorDriverInterface
{
    const TRAIT_NAME = 'TraitUnitTest';
    /**
     * @return void
     */
    public function process(): void
    {
        //prepare stuff
        /** @var CG\UnitTest $annotation */
        $annotation = $this->getAnnotation();
        $templateVariable = new ArrayCollection($this->getBasics([],'unitTests'));
        $config = [];
        $parameters = (new UnitObject())->setAnnotation($annotation)->setTemplateVariable(new ArrayCollection())->setConfig([]);

        // Process Each Sub Item
        $parameters->setMethodName('getMocks');
        $this->processObject($parameters);
        $parameters->setMethodName('getVfs');
        $this->processObject($parameters);
        $parameters->setMethodName('getFunctions');
        $this->processObject($parameters);
        $parameters->setMethodName('getDataProvider');
        $this->processObject($parameters);

        // First Run Unit Test Preperation
        $unitTest = new UnitGenerator($this->file, $annotation, $this->getService());
        $unitTest->setTemplateVariables($templateVariable)->setConfig($config);
        $unitTest->setTemplateVariables($templateVariable);
        $unitTest->setRenderedOutput($parameters->getRenderedCollection());
        $unitTest->process();
    }

    /**
     * @param \MjrOne\CodeGeneratorBundle\Document\UnitObject $object
     */
    protected function processObject(UnitObject $object)
    {
        /** @var CG\UnitTest $annotation */
        $methodName = $object->getMethodName();
        $annotation = $object->getAnnotation();
        if(!empty($annotation->{$methodName}()))
        {
            foreach($annotation->{$methodName}() as $objectItem)
            {
                $class = get_class($objectItem);
                $driver = $class::DRIVER;
                /** @var \MjrOne\CodeGeneratorBundle\Generator\Driver\SubDriverInterface $instance */
                $instance = new $driver($this->file, $objectItem, $this->getService());
                if(!($instance instanceof UnitTestInterface))
                {
                    continue;
                }
                $instance->setTemplateVariables($object->getTemplateVariable());
                $instance->setConfig($object->getConfig());
                $instance->process();
                $object->setConfig($instance->getConfig());
                $object->setTemplateVariable($instance->getTemplateVariables());
                $object->getRenderedCollection()->add($instance->getRenderedOutput());
            }
        }
    }

    public function generate()
    {

    }
}
