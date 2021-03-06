<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\PhpUnit;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Document\Method;
use MjrOne\CodeGeneratorBundle\Document\RenderedOutput;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FunctionGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\PhpUnit
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   LGPL V3
 * @link      http://www.mjr.one
 */
class FunctionCodeGenerator extends CodeGeneratorAbstract implements CodeGeneratorInterface, UnitTestInterface
{
    protected $methodDefinition;
    /**
     * @return void
     * @throws \MjrOne\CodeGeneratorBundle\Exception\TypeNotAllowedException
     * @throws \MjrOne\CodeGeneratorBundle\Exception\NoContentException
     */
    public function process(): void
    {
        /** @var UT\TestFunction $annotation */
        $annotation = $this->getAnnotation();
        $methodAnnotations = $this->getDocumentAnnotation()->getMethodAnnotation($annotation->getName());
        $templateVariables = $annotation->toArray();
        $templateVariables['baseClass'] = $this->getTemplateVariables()->toArray();
        $templateVariables['providerPrefix'] = DataProviderCodeGenerator::PROVIDER_PREFIX;
        $templateVariables['strict'] = $this->getService()->getConfig()->getFileProperties()->isUseStrictTypes();
        /** @var CG\UnitTest $unitTestAnnotation */
        $unitTestAnnotation = $this->getDocumentAnnotation()->getClassAnnotation(CG\UnitTest::class);
        $templateVariables['symfonyController'] = !empty($unitTestAnnotation->isSymfonyController());
        $templateVariables['Route'] = '/';
        $templateVariables['methods'] = ['GET'];
        if($methodAnnotations instanceof Method)
        {
            /** @var Route $routeAnnotation */
            $routeAnnotation = $methodAnnotations->getAnnotation(Route::class);
            $templateVariables['Route'] = $routeAnnotation->getPath();
            $templateVariables['methods'] = $routeAnnotation->getMethods();
        }

        $this->setRenderedOutput(
            new RenderedOutput(
                RenderedOutput::TYPE_TEST_METHOD, $this->getRenderer()->renderTemplate(
                    'MjrOneCodeGeneratorBundle:PhpUnit:function.php.twig', $templateVariables
                )
            )
        );
    }
}
