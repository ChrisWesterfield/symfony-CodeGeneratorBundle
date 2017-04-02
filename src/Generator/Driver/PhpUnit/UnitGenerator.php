<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit;

use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Converter\File;
use MjrOne\CodeGeneratorBundle\Document\Annotation;
use MjrOne\CodeGeneratorBundle\Document\RenderedOutput;
use MjrOne\CodeGeneratorBundle\Generator\GeneratorDriverInterface;

/**
 * Class VirtualFileSystemGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Driver\PhpUnit
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   LGPL V3
 * @link      http://www.mjr.one
 */
class UnitGenerator extends GeneratorAbstract implements GeneratorDriverInterface, UnitTestInterface
{
    const TRAIT_PREFIX = 'TraitUnitTest';
    const CLASS_SUFFIX = 'Test';
    const TEST_DIRECTORY = 'Tests';

    /**
     * @return void
     */
    public function process(): void
    {
        //prepare Data
        $traitTemplate = $this->getTemplateVariables();
        $nameSpace = $this->getDocumentAnnotation()->getBundleRootNamespace();
        $coreNameSpace = $nameSpace . '\\Tests\\';
        $fileNamespace = str_replace($nameSpace . '\\', '', $this->getDocumentAnnotation()->getNamespace());

        $traitNameSpace = $coreNameSpace . '\\' . Annotation::TRAIT_NAMESPACE . '\\' . $fileNamespace;
        $traitNameSpace = str_replace('\\\\', '\\', $traitNameSpace);

        $classNamespace = $coreNameSpace . '\\' . $fileNamespace;
        $classNamespace = str_replace('\\\\', '\\', $classNamespace);

        $functionContainer = [];

        /** @var RenderedOutput[] $outputs */
        $outputs = $this->getRenderedOutput();
        $basePathTest = $this->getRootPath() . '/' . $this->getRootFilePath() . '/' . self::TEST_DIRECTORY;
        $validationName = 'Bundle/' . self::TEST_DIRECTORY;
        $detectLength = (-1 * strlen($validationName));
        if (!substr($basePathTest, $detectLength, $detectLength) !== $validationName)
        {
            $basePathTest = str_replace('src/' . self::TEST_DIRECTORY, self::TEST_DIRECTORY, $basePathTest);
        }
        $basePathTest = str_replace('//', '/', $basePathTest);


        //write Trait
        $templateVariables = $this->getTemplateVariables()->toArray();
        $templateVariables['class'] =
            self::TRAIT_PREFIX . $this->getDocumentAnnotation()->getReflectionClass()->getShortName();
        $templateVariables['namespace'] = $traitNameSpace;
        $templateVariables['methods'] = [];
        $templateVariables['setup'] = [];
        if (!empty($outputs))
        {
            foreach ($outputs as $item)
            {
                switch ($item->getType())
                {
                    case RenderedOutput::TYPE_METHOD:
                        $templateVariables['methods'][] = $item->getContent();
                        break;
                    case RenderedOutput::TYPE_SETUP:
                        $templateVariables['setup'][] = $item->getContent();
                        break;
                    case RenderedOutput::TYPE_TEST_METHOD:
                        $functionContainer[] = $item->getContent();
                        break;
                }
            }
        }
        $basePathTrait =
            $basePathTest . '/' . self::NAMESPACE_DIRECTORY_FOR_TRAITS . '/' . str_replace('\\', '/', $fileNamespace);
        $fileName = self::TRAIT_PREFIX . $this->getDocumentAnnotation()->getClassShort() . self::FILE_EXTENSION;
        $output = $this->getRenderer()->renderTemplate(
            'MjrOneCodeGeneratorBundle:PhpUnit:trait.php.twig', $templateVariables
        );
        $this->writeToDisk($basePathTrait, $fileName, $output);

        $basePathTestClass = $basePathTest . '/' . $fileNamespace.'/';
        $basePathTestClass = str_replace('//', '/', $basePathTestClass);
        $fileContainer = (new File())->readFile(
            $basePathTestClass
            . $this->getDocumentAnnotation()->getClassShort()
            . self::CLASS_SUFFIX
            . self::FILE_EXTENSION,
            $this->getDocumentAnnotation()->getReflectionClass()
        );
    }
}
