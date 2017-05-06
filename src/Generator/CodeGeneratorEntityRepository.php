<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\EntityRepositoryGeneratorEvent;
use MjrOne\CodeGeneratorBundle\Generator\CodeGeneratorInterface;

/**
 * Class EntityRepositoryGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class CodeGeneratorEntityRepository extends CodeGeneratorAbstract implements CodeGeneratorInterface
{
    const REPOSITORY_POSTFIX = 'Repository';
    const REPOSITORY_DIRECTORY = 'Repository';
    const FILE_EXTENSION = '.php';

    /**
     * @return void
     */
    public function process():void
    {
        /** @var CG\Entity $workingAnnotation */
        $workingAnnotation = $this->getAnnotation();
        if (empty($workingAnnotation->getRepository()))
        {
            $workingAnnotation->setRepository(
                $this->getDocumentAnnotation()->getClassShort() . self::REPOSITORY_POSTFIX
            );
        }
        if (empty($workingAnnotation->getTargetNameSpace()))
        {
            $workingAnnotation->setTargetNameSpace(
                $this->getDocumentAnnotation()->getBundleRootNamespace() . '\\' . self::REPOSITORY_DIRECTORY
            );
        }
        $originalPath = (method_exists($this->kernel, 'getRealRootDirectory') ? $this->kernel->getRealRootDirectory()
                : $this->kernel->getRootDir() . '/../') . '/';
        $originalPath = str_replace('//','/',$originalPath);
        if (empty($workingAnnotation->getTargetDirectory()))
        {
            $workingAnnotation->setTargetDirectory($this->getRootFilePath() . '/' . self::REPOSITORY_DIRECTORY);
        }
        $path = $workingAnnotation->getTargetDirectory() . '/';
        $file = $workingAnnotation->getRepository() . self::FILE_EXTENSION;
        if(!$this->fileSystem->exists($path.$file))
        {
            $templateVariables = [];
            $templateVariables = $this->getBasics($templateVariables, $workingAnnotation->getRepository());
            $templateVariables['class'] = $workingAnnotation->getRepository();
            $templateVariables['namespace'] = $workingAnnotation->getTargetNameSpace();
            $templateVariables['baseClass'] = $workingAnnotation->getExtendsShort();
            $templateVariables['baseClassFQDN'] = $workingAnnotation->getExtendsClass();

            $event = (new EntityRepositoryGeneratorEvent())->setSubject($this)->setTemplateVariable($templateVariables);
            $this->getED()->dispatch($this->getED()->getEventName(self::class, 'preProcess'), $event);
            $templateVariables = $event->getTemplateVariable();

            $output = $this->getRenderer()->renderTemplate(
                "MjrOneCodeGeneratorBundle:Entity:Repository.php.twig", $templateVariables
            );

            $event = (new EntityRepositoryGeneratorEvent())->setSubject($this)->setContent($output);
            $this->getED()->dispatch($this->getED()->getEventName(self::class, 'postRender'), $event);
            $output = $event->getContent();

            $this->writeToDisk($path, $file, $output);
        }
        $fileContainer = $this->getKernel()->getContainer()->get('mjrone.codegenerator.php.parser.file')->readFile($this->getFilePath());
        $comments = explode("\n",$fileContainer->getClassComment());
        /** @var Entity $entityAnnotation */
        $entityAnnotation = $this->getDocumentAnnotation()->getClassAnnotationObect(Entity::class);
        $repository = '\\'.$workingAnnotation->getTargetNameSpace().'\\'.$workingAnnotation->getRepository();
        $annotationFound = false;
        $newComment = [];

        $event = (new EntityRepositoryGeneratorEvent())->setSubject($this)->setFileContainer($fileContainer);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'preFileContainerModification'), $event);
        /**
         * @param $annotation
         * @return string
         */
        $orm = function($annotation) use ($repository, $entityAnnotation)
        {
            /** @var Entity $entityAnnotation */
            $annotationArray = explode('(', $annotation);
            if(strpos($annotation, 'repositoryClass')!==false)
            {
                return $annotation;
            }
            $newEntityString = $annotationArray[0].'( repositoryClass="'.$repository.'" ';
            if($entityAnnotation->readOnly)
            {
                $newEntityString .= 'readOnly=true';
            }
            return $newEntityString.')';
        };
        foreach($comments as $comment)
        {
            if(strpos($comment, '@ORM\Entity(') !== false)
            {
                $newComment[] = $orm($comment);
                continue;
            }
            if(strpos($comment,'Doctrine\ORM\Mapping\Entity')!==false)
            {
                $newComment[] = $orm($comment);
                continue;
            }
            if(strpos($comment,'\Doctrine\ORM\Mapping\Entity')!==false)
            {
                $newComment[] = $orm($comment);
                continue;
            }
            $newComment[] = $comment;
        }
        $fileContainer->setClassComment(implode("\n",$newComment));

        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'preFileModification'), $event);

        $this->getKernel()
            ->getContainer()
            ->get('mjrone.codegenerator.php.writer')
            ->writeDocument($fileContainer,$this->getFilePath());

        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'postFileModification'), $event);

        $event = (new EntityRepositoryGeneratorEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'finished'), $event);
    }
}
