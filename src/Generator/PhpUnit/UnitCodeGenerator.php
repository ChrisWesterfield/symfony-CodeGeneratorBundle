<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\PhpUnit;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Tests as UT;
use MjrOne\CodeGeneratorBundle\Event\UnitCodeGeneratorEvent;
use MjrOne\CodeGeneratorBundle\Event\UnitCodeGeneratorMethodEvent;
use MjrOne\CodeGeneratorBundle\Php\Document\File as FileContainer;
use MjrOne\CodeGeneratorBundle\Php\Document\Method as MethodDocument;
use MjrOne\CodeGeneratorBundle\Php\Parser\File;
use MjrOne\CodeGeneratorBundle\Document\Annotation;
use MjrOne\CodeGeneratorBundle\Document\RenderedOutput;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorInterface;
use MjrOne\CodeGeneratorBundle\Php\Parser\Method;

/**
 * Class VirtualFileSystemGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\PhpUnit
 * @author    Chris Westerfield <chris@mjr.one>
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   LGPL V3
 * @link      http://www.mjr.one
 */
class UnitCodeGenerator extends CodeGeneratorAbstract implements CodeGeneratorInterface, UnitTestInterface
{
    public const TRAIT_PREFIX = 'TraitUnitTest';
    public const CLASS_SUFFIX = 'Test';
    public const TEST_DIRECTORY = 'Tests';

    /**
     * @return void
     */
    public function process(): void
    {
        $event = (new UnitCodeGeneratorEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'processPrepare'),$event);
        //prepare Data
        $traitTemplate = $this->getTemplateVariables();
        $nameSpace = $this->getDocumentAnnotation()->getBundleRootNamespace();
        $coreNameSpace = $nameSpace . '\\Tests\\';
        $fileNamespace = str_replace($nameSpace . '\\', '', $this->getDocumentAnnotation()->getNamespace());

        $traitNameSpace = $coreNameSpace . '\\' . Annotation::TRAIT_NAMESPACE . '\\' . $fileNamespace;
        $traitNameSpace = str_replace('\\\\', '\\', $traitNameSpace);

        $classNamespace = $coreNameSpace . '\\' . $fileNamespace;
        $classNamespace = str_replace('\\\\', '\\', $classNamespace);
        $basePathTest = $this->getRootPath() . '/' . $this->getRootFilePath() . '/' . self::TEST_DIRECTORY;
        $validationName = 'Bundle/' . self::TEST_DIRECTORY;
        $detectLength = (-1 * strlen($validationName));
        if (!substr($basePathTest, $detectLength, $detectLength) !== $validationName) {
            $basePathTest = str_replace('src/' . self::TEST_DIRECTORY, self::TEST_DIRECTORY, $basePathTest);
        }
        $basePathTest = str_replace('//', '/', $basePathTest);

        $event = (new UnitCodeGeneratorEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'processPre'),$event);


        $event = (new UnitCodeGeneratorEvent())
            ->setSubject($this)
            ->setBasePathTest($basePathTest)
            ->setTraitNameSpace($traitNameSpace)
            ->setFileNameSpace($fileNamespace);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'processPre'),$event);

        $functions = $this->writeTraitAndReturnFunctionContainer(
            $event->getTraitNameSpace(),
            $event->getBasePathTest(),
            $event->getFileNameSpace()
        );

        $event = (new UnitCodeGeneratorEvent())
            ->setSubject($this)
            ->setWriteTestClassParameter([
                'traitNameSpace' => $traitNameSpace,
                'traitName' => self::TRAIT_PREFIX . $this->getDocumentAnnotation()->getReflectionClass()->getShortName(),
                'basePath' => $basePathTest,
                'fileNamespace' => $fileNamespace,
                'functions' => $functions
            ]);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'processClasspre'),$event);

        $this->writeTestClass($event->getWriteTestClassParameter());

        $event = (new UnitCodeGeneratorEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'processPost'),$event);

    }

    /**
     * @param array $testClassData
     */
    protected function writeTestClass(array $testClassData)
    {
        $basePathTestClass = $testClassData['basePath'] . '/' . $testClassData['fileNamespace'] . '/';
        $basePathTestClass = str_replace('//', '/', $basePathTestClass);
        $file = $basePathTestClass
            . $this->getDocumentAnnotation()->getClassShort()
            . self::CLASS_SUFFIX
            . self::FILE_EXTENSION;
        $fileContainer = (new File())->readFile(
            $file
        );

        $fileContainer = $this->updateFileContainer($fileContainer, $testClassData['functions'],['traitNameSpace'=>$testClassData['traitNameSpace'],'traitName'=>$testClassData['traitName']]);

        $event = (new UnitCodeGeneratorEvent())->setFileContainer($fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'writeTestClassPre'),$event);
        $writer = $this->getKernel()->getContainer()->get('mjrone.codegenerator.php.writer');
        $writer->writeDocument($fileContainer, $file);

    }

    /**
     * @param FileContainer $fileContainer
     * @param string[] $methods
     * @param array $trait
     *
     * @return FileContainer
     */
    public function updateFileContainer(FileContainer $fileContainer, array $methods, array $trait): FileContainer
    {
        $traitNameSpaceFull = $trait['traitNameSpace'].'\\'.$trait['traitName'];
        if(!$fileContainer->hasUsedNamespace($traitNameSpaceFull))
        {
            $fileContainer->addUsedNamespace($traitNameSpaceFull);
        }
        if(!$fileContainer->hasTraitUse($trait['traitName']))
        {
            $fileContainer->addTraitUse($trait['traitName']);
        }
        $event = (new UnitCodeGeneratorEvent())->setSubject($this)->setFileContainer($fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'updateFileContainerPre'),$event);
        foreach ($methods as $method) {
            $method = "<?php" . $method;
            $tokens = token_get_all($method);
            $methodArray = (new Method())->parseDocument($method, $tokens);
            $methodObject = array_shift($methodArray);

            $event = (new UnitCodeGeneratorMethodEvent())
                ->setSubject($this)
                ->setMethod($methodObject);
            $this->getED()->dispatch($this->getED()->getEventName(self::class,'updateFileContainerProcessPre'),$event);

            if ($fileContainer->getMethods()->count() < 1) {
                $fileContainer->addMethod($methodObject);
            } else {
                $methodId = $fileContainer->getMethodId($methodObject->getName());
                if ($methodId === false) {
                    $event = (new UnitCodeGeneratorMethodEvent())
                        ->setSubject($this)
                        ->setMethod($methodObject);
                    $this->getED()->dispatch($this->getED()->getEventName(self::class,'updateFileContainerProcessPreAdd'),$event);
                    $fileContainer->addMethod($methodObject);
                } else {
                    /** @var MethodDocument $fileMethod */
                    $fileMethod = $fileContainer->getMethods()->get($methodId);
                    $event = (new UnitCodeGeneratorMethodEvent())
                        ->setSubject($this)
                        ->setMethod($methodObject)
                        ->setFileMethod($fileMethod);
                    $this->getED()->dispatch($this->getED()->getEventName(self::class,'updateFileContainerProcessPreModify'),$event);
                    $fileMethod->setComment($methodObject->getComment());
                    $fileMethod->setVisibility($methodObject->getVisibility());
                    $fileMethod->setVariables($methodObject->getVariables());
                    $fileContainer->getMethods()->set($methodId, $fileMethod);
                }
            }
        }

        return $fileContainer;
    }

    /**
     * @param string $traitNameSpace
     * @param string $basePathTest
     *
     * @param string $fileNamespace
     *
     * @return array
     */
    protected function writeTraitAndReturnFunctionContainer(string $traitNameSpace, string $basePathTest, string $fileNamespace)
    {
        $functionContainer = [];
        /** @var RenderedOutput[] $outputs */
        $outputs = $this->getRenderedOutput();
        //write Trait
        $templateVariables = $this->getTemplateVariables()->toArray();
        $templateVariables['class'] =
            self::TRAIT_PREFIX . $this->getDocumentAnnotation()->getReflectionClass()->getShortName();
        $templateVariables['namespace'] = $traitNameSpace;
        $templateVariables['methods'] = [];
        $templateVariables['setup'] = [];
        if (!empty($outputs)) {
            foreach ($outputs as $item) {
                switch ($item->getType()) {
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

        $event = (New UnitCodeGeneratorEvent())->setSubject($this)->setTemplateVariables($templateVariables);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preWriteTraitEvent'),$event);

        $output = $this->getRenderer()->renderTemplate(
            'MjrOneCodeGeneratorBundle:PhpUnit:trait.php.twig', $event->getTraitNameSpace()
        );
        $this->writeToDisk($basePathTrait, $fileName, $output);

        return $functionContainer;
    }
}
