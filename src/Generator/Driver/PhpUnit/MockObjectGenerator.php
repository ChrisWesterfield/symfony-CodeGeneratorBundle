<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Document\RenderedOutput;
use MjrOne\CodeGeneratorBundle\Exception\ClassDoesNotExistException;
use MjrOne\CodeGeneratorBundle\Exception\NoClassNameGivenForMockObjectException;
use MjrOne\CodeGeneratorBundle\Exception\NoContentException;
use MjrOne\CodeGeneratorBundle\Exception\TypeNotAllowedException;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorDriverInterface;

/**
 * Class MockObjectGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 */
class MockObjectGenerator extends GeneratorAbstract implements GeneratorDriverInterface, UnitTestInterface
{
    /**
     * @return void
     * @throws TypeNotAllowedException
     * @throws NoContentException
     * @throws ClassDoesNotExistException
     * @throws NoClassNameGivenForMockObjectException
     */
    public function process(): void
    {
        /** @var UT\MockObject $annotation */
        $annotation = $this->getAnnotation();
        if($annotation->getClass()===null)
        {
            throw new NoClassNameGivenForMockObjectException('The MockObject requires to have at least an ClassName!');
        }
        $className = $annotation->getClass();
        if($className==='self')
        {
            $className = $this->getDocumentAnnotation()->getReflectionClass()->getName();
        }
        if(!class_exists($className))
        {
            throw new ClassDoesNotExistException('The Class '.$className.' does not exist!');
        }
        $templateVariables = $annotation->toArray();
        $templateVariables['mockObjectClassName'] = $className;
        $templateVariables['baseClass'] = $this->getTemplateVariables()->toArray();
        $templateVariables['MethodName'] = ucfirst($annotation->getName());
        $templateVariables['strict'] = $this->getService()->getConfig()->getFileProperties()->isUseStrictTypes();
        $this->setRenderedOutput(
            new RenderedOutput(
                RenderedOutput::TYPE_METHOD, $this->getRenderer()->renderTemplate
                (
                    'MjrOneCodeGeneratorBundle:PhpUnit:mock.php.twig', $templateVariables
                )
            )
        );
    }
}
