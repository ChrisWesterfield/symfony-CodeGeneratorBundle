<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 13/03/2017
 * Time: 21:30
 */

namespace MjrOne\CodeGeneratorBundle\Services\Driver;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Annotation\Service\Variable;
use MjrOne\CodeGeneratorBundle\Event\ServiceGeneratorEvent;
use MjrOne\CodeGeneratorBundle\Services\Driver\Service\ServicePropertiesGenerator;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ServiceGenerator
 *
 * @package MjrOne\CodeGeneratorBundle\Services\Driver
 */
class ServiceGenerator extends GeneratorAbstract
{
    const TEMPLATE  = 'MjrOneCodeGeneratorBundle:Service:base.php.twig';
    const TRAITNAME = 'TraitService';

    /**
     *
     */
    public function process()
    {
        $templateVariables = new ArrayCollection();
        $config = Yaml::parse(file_get_contents($this->getServiceConfigFile()));
        $event = (new ServiceGeneratorEvent())->setTemplateVars($templateVariables)->setConfig($config)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preProcess'),$event);
        $templateVariables = $event->getTemplateVars();
        $config = $event->getConfig();
        //first Process Core Service Stuff
        $this->processService($templateVariables, $config);
        $event = (new ServiceGeneratorEvent())->setTemplateVars($templateVariables)->setConfig($config)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'postProcess'),$event);
        $templateVariables = $event->getTemplateVars();
        $config = $event->getConfig();
        $templateVariables->set('useList', $this->createUseList($templateVariables));
        //iterate over addition Service Class Interface Properties
        foreach ($this->getDocumentAnnotation()->getClasses() as $annotation)
        {
            if ($annotation instanceof CG\SubDriverInterface)
            {
                $class = get_class($annotation);
                $driver = $class::DRIVER;
                list(
                    $config, $templateVariables
                    ) = $this->processInstance($driver, $annotation, $templateVariables, $config);
            }
        }
        if ($this->getDocumentAnnotation()->getProperties()->count() > 0)
        {
            list(
                $config, $templateVariables
                ) = $this->processInstance(
                ServicePropertiesGenerator::class, $this->getAnnotation(), $templateVariables, $config
            );
        }
        /**
         *  Cleanup
         */
        $serviceName = $templateVariables->get('serviceName');
        if (empty($config['services'][$serviceName]['arguments']))
        {
            unset($config['services'][$serviceName]['arguments']);
        }
        if (empty($config['services'][$serviceName]['calls']))
        {
            unset($config['services'][$serviceName]['calls']);
        }
        if (empty($config['services'][$serviceName]['tags']))
        {
            unset($config['services'][$serviceName]['tags']);
        }
        $result = $this->writeDocument($templateVariables);
        if ($result)
        {
            $this->checkFileForTrait($templateVariables);
            $this->processServiceConfig($config);
        }
    }

    /**
     * @param string                                                     $driver
     * @param \MjrOne\CodeGeneratorBundle\Annotation\AnnotationInterface $annotation
     * @param \Doctrine\Common\Collections\ArrayCollection               $templateVariable
     * @param array                                                      $config
     *
     * @return array
     */
    protected function processInstance(
        string $driver, CG\AnnotationInterface $annotation, ArrayCollection $templateVariable, array $config
    )
    {
        $event = (new ServiceGeneratorEvent())->setTemplateVars($templateVariable)->setConfig($config)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preSubProcess'),$event);
        $templateVariable = $event->getTemplateVars();
        $config = $event->getConfig();
        /** @var SubDriverInterface $instance */
        $instance = new $driver($this->getFile(), $annotation, $this->getService());
        $instance->setConfig($config);
        $instance->setTemplateVariables($templateVariable);
        $instance->process();
        $config = $instance->getConfig();
        $templateVariable = $instance->getTemplateVariables();
        $event = (new ServiceGeneratorEvent())->setTemplateVars($templateVariable)->setConfig($config)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'postSubProcess'),$event);
        $templateVariable = $event->getTemplateVars();
        $config = $event->getConfig();

        return [$config, $templateVariable];
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $templateVars
     * @param array                                        $config
     */
    protected function processService(ArrayCollection $templateVars, array &$config)
    {
        /** @var CG\Service\Service $annotation */
        $annotation = $this->getAnnotation();
        /** @var CG\Service\Construction[] $constructorMethods */
        $constructorMethods = $annotation->getConstructorMethods();
        $constructors = [];
        if (!empty($constructorMethods))
        {
            foreach ($constructorMethods as $method)
            {
                $methodArray = $method->toArray();
                if (!empty($methodArray['variables']))
                {
                    foreach ($methodArray['variables'] as $id => $variable)
                    {
                        /** @var Variable $variable */
                        $methodArray['variables'][$id] = $variable->toArray();
                    }
                }
                $constructors[] = $methodArray;
            }
            $templateVars->set('constructorMethods', $constructors);
        }
        $event = (new ServiceGeneratorEvent())->setTemplateVars($templateVars)->setConfig($config)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'processServiceConstructor'),$event);
        $templateVars = $event->getTemplateVars();
        $config = $event->getConfig();
        $vars = $this->getBasics([], self::TRAITNAME);
        foreach ($vars as $id => $value)
        {
            $templateVars->set($id, $value);
        }
        $event = (new ServiceGeneratorEvent())->setTemplateVars($templateVars)->setConfig($config)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'processServiceBasics'),$event);
        $templateVars = $event->getTemplateVars();
        $config = $event->getConfig();
        $serviceName = $annotation->getName();
        if ($serviceName)
        {
            $className = $this->getDocumentAnnotation()->getFqdnName();
            $serviceName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
            $serviceName = str_replace(['\\', '._'], '.', $serviceName);
            $serviceName = trim($serviceName, '.');
        }
        $config['services'][$serviceName] = [
            'class'     => $this->getDocumentAnnotation()->getFqdnName(),
            'arguments' => [],
            'calls'     => [],
            'tags'      => [],
            'lazy'      => $annotation->isLazy(),
            'public'    => $annotation->isPublicService(),
        ];
        if ($annotation->isDepricated())
        {
            $config['services'][$serviceName]['deprecated'] = '~';
            if (!empty($annotation->getDepricatedMessage()))
            {
                $config['services'][$serviceName]['deprecated'] = $annotation->getDepricatedMessage();
            }
        }
        $templateVars->set('serviceName', $serviceName);
        $templateVars->set('route', $annotation->isController());
        $event = (new ServiceGeneratorEvent())->setTemplateVars($templateVars)->setConfig($config)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'processServicePost'),$event);
        $templateVars = $event->getTemplateVars();
        $config = $event->getConfig();
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $templateVariables
     *
     * @return bool
     */
    protected function writeDocument(ArrayCollection $templateVariables)
    {
        $event = (new ServiceGeneratorEvent())->setTemplateVars($templateVariables)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'writeDocumentPre'),$event);
        $templateVariables = $event->getTemplateVars();
        $output = $this->getRenderer()->renderTemplate(self::TEMPLATE, $templateVariables->toArray());
        $event = (new ServiceGeneratorEvent())->setSubject($this)->setContent($output);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'writeDocumentPost'),$event);
        $output = $event->getContent();
        $result = $this->getTraitFile($this->file, self::TRAITNAME);
        if (!empty($result))
        {
            list($path, $fileName) = $result;
            $this->writeToDisk($path, $fileName, $output);
            $event = (new ServiceGeneratorEvent())->setSubject($this);
            $this->getED()->dispatch($this->getED()->getEventName(self::class,'writeDocumentPostDump'),$event);
            return true;
        }

        return false;
    }

    /**
     * @param $config
     */
    protected function processServiceConfig($config)
    {
        $yml = Yaml::dump($config, 100);
        $this->getFileSystem()->dumpFile($this->getServiceConfigFile(), $yml);
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $templateVariables
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    protected function createUseList(ArrayCollection $templateVariables)
    {
        $list = new ArrayCollection([
            'loc'=>[],
        ]);
        $this->addToList((string)$templateVariables->get('usedBy'),$list);
        $this->addToList('MjrOne\CodeGeneratorBundle\Annotation',$list,'CG');
        $this->addToList($this->getService()->getConfig()->getCore()->getResponse(),$list);
        $this->addToList($this->getService()->getConfig()->getCore()->getRequest(),$list);
        $this->addToList($this->getService()->getConfig()->getCore()->getRedirect(),$list);
        $this->addToList(\LogicException::class,$list);
        return $list;
    }
}
