<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\CodeGenerators\Driver;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\RepositoryGeneratorEvent;
use Symfony\Component\Yaml\Yaml;

/**
 * Class RepositoryGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\CodeGenerators\Driver
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class RepositoryGenerator extends GeneratorAbstract implements GeneratorInterface
{
    const TRAIT_NAME            = 'TraitRepository';
    const NAMESPACE_REPOSITORY  = '\\Repository\\';
    const NAMESPACE_ENTITY      = '\\Entity\\';
    const REPOSITORY_IDENTIFIER = 'Repository';

    /**
     *
     */
    public function process()
    {
        $templateVariables = new ArrayCollection($this->getBasics([], self::TRAIT_NAME));
        /** @var CG\Repository $annotation */
        $annotation = $this->getAnnotation();
        $settings = [];
        $settings['softdelete'] = $annotation->isSoftDelete();
        $settings['persist'] = $annotation->isPersist();
        $settings['transaction'] = $annotation->isTransaction();
        $settings['remove'] = $annotation->isRemove();
        $settings['flush'] = $annotation->isFlush();
        if ($annotation->isRemove() || $annotation->isPersist())
        {
            $settings['flush'] = true;
        }
        $settings['results'] = $annotation->isResults();
        $settings['result'] = $annotation->isResult();
        $settings['em'] = $annotation->isEm();
        $settings['queryBuilder'] = $annotation->isQueryBuilder();
        if (empty($annotation->getEntity()))
        {
            $annotation->setEntity($this->getEntity());
        }
        $templateVariables->set('settings', $settings);
        $event = (new RepositoryGeneratorEvent())->setSubject($this)->setTemplateVariable($templateVariables);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'preRender'), $event);
        $output = $this->getRenderer()->renderTemplate(
            'MjrOneCodeGeneratorBundle:Repository:base.php.twig', $templateVariables->toArray()
        );
        $event->setContent($output);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'postRender'), $event);
        $output = $event->getContent();
        $result = $this->getTraitFile($this->file, self::TRAIT_NAME);
        if (!empty($result))
        {
            list($path, $fileName) = $result;
            $this->writeToDisk($path, $fileName, $output);
            $this->checkFileForTrait($templateVariables);
            $this->checkServiceConfig($templateVariables, $annotation);
            $this->checkEntityFile($templateVariables, $annotation);
        }
    }

    /**
     * @return string
     */
    protected function getEntity()
    {
        //we need to guess the entity. Guessing is based on: Entity is located under ../Entity
        $entity = $this->getDocumentAnnotation()->getReflectionClass()->getName();
        $entity = str_replace(self::NAMESPACE_REPOSITORY, self::NAMESPACE_ENTITY, $entity);
        $entity = explode('\\', $entity);
        $work = array_pop($entity);
        if (strpos($work, self::REPOSITORY_IDENTIFIER) !== false)
        {
            $work = explode(self::REPOSITORY_IDENTIFIER, $work);
            array_pop($work);
            $work = implode(self::REPOSITORY_IDENTIFIER, $work);
            $entity[] = $work;
        }
        else
        {
            $entity[] = $work;
        }
        $entityClassName = implode('\\', $entity);
        $event = (new RepositoryGeneratorEvent())->setSubject($this)->setEntityClassName($entityClassName);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'getEntity'), $event);

        return $event->getEntityClassName();
    }

    /**
     * @param                                                              $templateVariables
     * @param \MjrOne\CodeGeneratorBundle\Annotation\Repository            $annotation
     *
     * @return void
     * @todo add events
     */
    protected function checkServiceConfig($templateVariables, CG\Repository $annotation): void
    {
        $config = Yaml::parse(file_get_contents($this->getServiceConfigFile()));
        if (empty($annotation->getServiceName()))
        {
            $annotation->setServiceName($this->getServiceName());
        }

        $event = (new RepositoryGeneratorEvent())->setSubject($this)->setConfig($config);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'preServiceConfigure'), $event);
        $config = $event->getConfig();
        if (!array_key_exists($annotation->getServiceName(), $config['services']))
        {
            $config['services'][$annotation->getServiceName()] = [
                'class'     => 'Doctrine\ORM\EntityRepository',
                'factory'   => [
                    '@doctrine.orm.entity_manager',
                    'getRepository',
                ],
                'arguments' => [
                    $annotation->getEntity(),
                ],
            ];
        }

        $event = (new RepositoryGeneratorEvent())->setSubject($this)->setConfig($config);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'postServiceConfigure'), $event);
        $config = $event->getConfig();

        $this->processServiceConfig($config);
    }

    /**
     * @param                                                              $templateVariables
     * @param \MjrOne\CodeGeneratorBundle\Annotation\Repository            $annotation
     *
     * @return void
     */
    protected function checkEntityFile($templateVariables, CG\Repository $annotation): void
    {
        $reflection = new \ReflectionClass($annotation->getEntity());
        $file = $reflection->getFileName();

        $oldFile = file_get_contents($file);
        $oldFileArray = explode("\n", $oldFile);
        $newFile = [];

        $event = (new RepositoryGeneratorEvent())->setSubject($this)->setContent($oldFile);
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
        $fqdn = $this->getDocumentAnnotation()->getFqdnName();
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

        $event = (new RepositoryGeneratorEvent())->setSubject($this)->setContent($oldFile);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'postFileModification'), $event);
        $oldFile = $event->getContent();

        file_put_contents($file, $newFile);

        $event = (new RepositoryGeneratorEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'finished'), $event);
    }
}
