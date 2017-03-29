<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Driver;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit\UnitGenerator;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorDriverInterface;

/**
 * Class PhpUnitCodeGeneratorService
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Driver
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 */
class PhpUnitCodeGeneratorService extends GeneratorAbstract implements GeneratorDriverInterface
{
    /**
     * @return void
     */
    public function process(): void
    {
        // First Run Unit Test Preperation
        $unitTest = new UnitGenerator();
        $unitTest->process();
        // Process Each Sub Item
        /** @var CG\UnitTest $annotation */
        $annotation = $this->getAnnotation();
        $this->processObject($annotation,'getMocks'); //Mocks
        $this->processObject($annotation,'getVfs'); //Virtual Filesystem Entries
        $this->processObject($annotation,'getFunctions'); //Functions
        $this->processObject($annotation,'getDataProvider'); //DataProvider
    }

    /**
     * @param \MjrOne\CodeGeneratorBundle\Annotation\SubDriverInterface|\MjrOne\CodeGeneratorBundle\Annotation\UnitTest $annotation
     * @param string                                                                                                    $functionName
     */
    protected function processObject(CG\UnitTest $annotation,string $functionName)
    {
        if(!empty($annotation->{$functionName}()))
        {
            foreach($annotation->{$functionName}() as $objectItem)
            {
                $class = get_class($annotation);
                $driver = $class::DRIVER;
                /** @var \MjrOne\CodeGeneratorBundle\Generator\Driver\SubDriverInterface $instance */
                $instance = new $driver();
                $instance->process();
            }
        }
    }
}
