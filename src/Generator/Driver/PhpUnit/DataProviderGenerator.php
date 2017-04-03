<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Document\RenderedOutput;
use MjrOne\CodeGeneratorBundle\Exception\NoProviderNameGivenException;
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
class DataProviderGenerator extends GeneratorAbstract implements GeneratorDriverInterface, UnitTestInterface
{
    const PROVIDER_PREFIX = 'getProvider';
    /**
     * @return void
     * @throws \MjrOne\CodeGeneratorBundle\Exception\TypeNotAllowedException
     * @throws \MjrOne\CodeGeneratorBundle\Exception\NoContentException
     * @throws \MjrOne\CodeGeneratorBundle\Exception\NoProviderNameGivenException
     */
    public function process(): void
    {
        $tmp = 1;
        /** @var UT\DataProvider $annotation */
        $annotation = $this->getAnnotation();
        $templateVariables = $annotation->toArray();
        if ($annotation->getName() === null)
        {
            throw new NoProviderNameGivenException('No Provider Name has been set!');
        }
        $templateVariables['basicClass'] = $this->getTemplateVariables()->toArray();
        $templateVariables['strict'] = $this->getService()->getConfig()->getFileProperties()->isUseStrictTypes();
        $templateVariables['methodName'] = 'getProvider' . ucfirst($annotation->getName());
        $templateVariables['providerData'] = $annotation->getData();
        $this->setRenderedOutput
        (
            new RenderedOutput
            (
                RenderedOutput::TYPE_METHOD, $this->getRenderer()->renderTemplate
                (
                    'MjrOneCodeGeneratorBundle:PhpUnit:dataProvider.php.twig', $templateVariables
                )
            )
        );
    }
}
