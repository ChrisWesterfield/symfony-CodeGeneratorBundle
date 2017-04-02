<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Document\RenderedOutput;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorDriverInterface;

/**
 * Class FunctionGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   LGPL V3
 * @link      http://www.mjr.one
 */
class FunctionGenerator extends GeneratorAbstract implements GeneratorDriverInterface, UnitTestInterface
{
    /**
     * @return void
     * @throws \MjrOne\CodeGeneratorBundle\Exception\TypeNotAllowedException
     * @throws \MjrOne\CodeGeneratorBundle\Exception\NoContentException
     */
    public function process(): void
    {
        /** @var UT\TestFunction $annotation */
        $annotation = $this->getAnnotation();
        $templateVariables = $annotation->toArray();
        $templateVariables['baseClass'] = $this->getTemplateVariables()->toArray();
        $templateVariables['providerPrefix'] = DataProviderGenerator::PROVIDER_PREFIX;
        $templateVariables['strict'] = $this->getService()->getConfig()->getFileProperties()->isUseStrictTypes();
        $this->setRenderedOutput(
            new RenderedOutput(
                RenderedOutput::TYPE_TEST_METHOD, $this->getRenderer()->renderTemplate(
                    'MjrOneCodeGeneratorBundle:PhpUnit:function.php.twig', $templateVariables
                )
            )
        );
    }
}
