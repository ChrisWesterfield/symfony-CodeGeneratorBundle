<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\PhpUnit;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Document\RenderedOutput;
use MjrOne\CodeGeneratorBundle\Exception\NoContentException;
use MjrOne\CodeGeneratorBundle\Exception\TypeNotAllowedException;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorInterface;

/**
 * Class VirtualFileSystemGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\PhpUnit
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 */
class VirtualFileSystemCodeGenerator extends CodeGeneratorAbstract implements CodeGeneratorInterface, UnitTestInterface
{
    /**
     * @return void
     * @throws TypeNotAllowedException
     * @throws NoContentException
     */
    public function process(): void
    {
        $templateVariables = $this->getAnnotation()->toArray();
        $templateVariables['basicClass'] = $this->getTemplateVariables()->toArray();
        $this->setRenderedOutput(new RenderedOutput(RenderedOutput::TYPE_SETUP,$this->getRenderer()->renderTemplate('MjrOneCodeGeneratorBundle:PhpUnit:vfs.php.twig',$templateVariables)));
    }
}
