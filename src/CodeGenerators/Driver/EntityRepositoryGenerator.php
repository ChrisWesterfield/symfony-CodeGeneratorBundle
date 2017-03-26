<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\CodeGenerators\Driver;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\EntityRepositoryGeneratorEvent;

/**
 * Class EntityRepositoryGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\CodeGenerators\Driver
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class EntityRepositoryGenerator extends GeneratorAbstract implements GeneratorInterface
{
    const REPOSITORY_POSTFIX = 'Repository';
    const REPOSITORY_DIRECTORY = 'Repository';
    const FILE_EXTENSION = '.php';

    public function process()
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
        if (empty($workingAnnotation->getTargetDirectory()))
        {
            $workingAnnotation->setTargetDirectory($this->getRootFilePath() . '/' . self::REPOSITORY_DIRECTORY);
        }
        $path = (method_exists($this->kernel, 'getRealRootDirectory') ? $this->kernel->getRealRootDirectory()
                : $this->kernel->getRootDir() . '/../') . '/';
        $originalPath = $path;
        $originalPath = str_replace('//', '/', $originalPath);
        $path .= $workingAnnotation->getTargetDirectory() . '/';
        $path = str_replace('//', '/', $path);
        $file = $workingAnnotation->getRepository() . self::FILE_EXTENSION;
        if ($this->getFileSystem()->exists($file))
        {
            return;
        }
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
        $oldFile = file_get_contents($originalPath . $this->getFile());
        $oldFileArray = explode("\n", $oldFile);
        $newFile = [];

        $event = (new EntityRepositoryGeneratorEvent())->setSubject($this)->setContent($oldFile);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'preFileModification'), $event);
        $oldFile = $event->getContent();

        /** @var Entity $searchedAnnotation */
        $searchedAnnotation = null;
        foreach ($this->getDocumentAnnotation()->getRawClassAnnotations() as $annotation)
        {
            if ($annotation instanceof Entity)
            {
                $searchedAnnotation = $annotation;
                break(1);
            }
        }
        /** Annotation is not part of where it was created! */
        if ($searchedAnnotation === null)
        {
            throw new \RuntimeException(
                'Entity Annotation ORM\Entity or ' . Entity::class . ' was not defined in Class '
                . $this->getDocumentAnnotation()->getFqdnName()
                . '! It could not be added. You neet to insert it on your own!'
            );
        }
        if ($searchedAnnotation->repositoryClass === null)
        {
            /** @var Entity $searchedAnnotation */
            $searchedAnnotation->repositoryClass = $this->getDocumentAnnotation()->getFqdnName();
        }
        $fqdn = '\\' . $workingAnnotation->getTargetNameSpace() . '\\' . $workingAnnotation->getRepository();
        $fqdn = str_replace('\\\\', '\\', $fqdn);
        foreach ($oldFileArray as $row)
        {
            if (strpos($row, '@ORM\Entity') !== false)
            {
                $annotationString =
                    ' * @ORM\Entity(repositoryClass="' . $fqdn . '", readOnly=' . ($searchedAnnotation->readOnly
                        ? 'true' : 'false') . ');';
                $newFile[] = $annotationString;
            }
            else if (strpos($row, Entity::class) !== false)
            {
                $annotationString = ' * @' . Entity::class . '(repositoryClass="' . $fqdn . '", readOnly='
                                    . ($searchedAnnotation->readOnly ? 'true' : 'false') . ');';
                $newFile[] = $annotationString;
            }
            else
            {
                $newFile[] = $row;
            }
        }
        $newFile = implode("\n", $newFile);

        $event = (new EntityRepositoryGeneratorEvent())->setSubject($this)->setContent($oldFile);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'postFileModification'), $event);
        $oldFile = $event->getContent();

        file_put_contents($originalPath . $this->getFile(), $newFile);

        $event = (new EntityRepositoryGeneratorEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'finished'), $event);
    }
}
