<?php
declare(strict_types = 1);

namespace MjrOne\CodeGeneratorBundle\Generator;

use Doctrine\Common\Collections\ArrayCollection;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\RoutingEvent;
use MjrOne\CodeGeneratorBundle\Services\ConfiguratorService;
use MjrOne\CodeGeneratorBundle\Services\EventDispatcherService;
use MjrOne\CodeGeneratorBundle\Services\ReadAnnotationService;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class RouterService
 *
 * @package MjrOne\CodeGeneratorBundle\Services
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class RouteGenerator extends CodeGeneratorSupportAbstract implements CodeGeneratorInterface
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var ReadAnnotationService
     */
    protected $annotationService;

    /**
     * @var array
     */
    protected $routingFile;

    /**
     * @var bool
     */
    protected $cleanup=false;

    /**
     * @var ConfiguratorService
     */
    protected $configuration;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var EventDispatcherService
     */
    protected $eventDispatcherService;

    /**
     * RouterService constructor.
     *
     * @param KernelInterface       $kernel
     * @param ReadAnnotationService $service
     * @param ConfiguratorService   $configuration
     */
    public function __construct(KernelInterface $kernel, ReadAnnotationService $service, ConfiguratorService $configuration, EventDispatcherService $dispatcher)
    {
        $this->kernel = $kernel;
        $this->annotationService = $service;
        $this->configuration = $configuration;
        $this->basePath = method_exists($this->kernel,'getRealRootDirectory')?$this->kernel->getRealRootDirectory():$this->kernel->getRootDir().'/../';
        $this->eventDispatcherService = $dispatcher;
        $event = (new RoutingEvent())->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'constructor'),$event);
    }

    public function process()
    {
        $production = $development = [];
        if($this->isCleanup())
        {
            $production = $this->getConfiguration()->getRouter()->getBaseRoutes()->getProductionRouteArray();
            $development = $this->getConfiguration()->getRouter()->getBaseRoutes()->getDevelopmentRouteArray();
        }
        else
        {
            $production = Yaml::parse(file_get_contents($this->basePath.'/'.$this->getConfiguration()->getRouter()->getProduction()));
            $development = Yaml::parse(file_get_contents($this->basePath.'/'.$this->getConfiguration()->getRouter()->getDevelopment()));
        }

        $event = (new RoutingEvent())->setSubject($this)->setProduction($production)->setDevelopment($development);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preProcess'),$event);
        $production = $event->getProduction();
        $development = $event->getDevelopment();

        $bundles = $this->kernel->getBundles();
        if(!empty($bundles))
        {
            foreach($bundles as $bundle)
            {
                $class = get_class($bundle);
                $refl = new \ReflectionClass($class);
                $annotations = $this->annotationService->get($refl->getFileName());
                /** @var ArrayCollection $classAnnotations */
                $classAnnotations = $annotations->getRawClassAnnotations();
                $classAnnotation = null;
                if($classAnnotations->count() > 0)
                {
                    foreach($classAnnotations as $annotation)
                    {
                        if($annotation instanceof CG\Routing)
                        {
                            $classAnnotation = $annotation;
                        }
                    }
                }
                if($classAnnotation === null)
                {
                    continue;
                }
                list($production, $development) = $this->processAnnotation($production, $development,$classAnnotation, $refl);
            }
        }

        $event = (new RoutingEvent())->setSubject($this)->setProduction($production)->setDevelopment($development);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'postProcess'),$event);
        $production = $event->getProduction();
        $development = $event->getDevelopment();
        $this->storeConfigs($production, $development);
    }

    /**
     * @param array $production
     * @param array $development
     */
    protected function storeConfigs(array $production, array $development)
    {

        $event = (new RoutingEvent())->setSubject($this)->setProduction($production)->setDevelopment($development);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preStore'),$event);
        $production = $event->getProduction();
        $development = $event->getDevelopment();

        $fs = new Filesystem();

        $productionArray = $this->convertArrayToYamlConfigArray($production);
        $event = (new RoutingEvent())->setSubject($this)->setCurrentConfig($productionArray)->setProduction($production);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'postConvertProductionArrayToYamlConfigArray'),$event);
        $productionYml = Yaml::dump($event->getCurrentConfig(),100);

        $event = (new RoutingEvent())->setSubject($this)->setContent($productionYml);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preStoreProductionYml'),$event);

        $fs->dumpFile($this->getBasePath().'/'.$this->getConfiguration()->getRouter()->getProduction(), $event->getContent());


        $developmentArray = $this->convertArrayToYamlConfigArray($development);
        $event = (new RoutingEvent())->setSubject($this)->setCurrentConfig($developmentArray)->setDevelopment($development);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'postConvertDevelopmentArrayToYamlConfigArray'),$event);
        $developmentYml = Yaml::dump($event->getCurrentConfig(),100);

        $developmentYml = Yaml::dump($developmentArray,100);
        $event = (new RoutingEvent())->setSubject($this)->setContent($developmentYml);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preStoreDevelopmentYml'),$event);
        $fs->dumpFile($this->getBasePath().'/'.$this->getConfiguration()->getRouter()->getDevelopment(),$event->getContent());
    }

    protected function convertArrayToYamlConfigArray(array $variable)
    {
        $returnSet = [];
        if(!empty($variable))
        {
            foreach($variable as $id=>$item)
            {
                $rowSet = [];
                if(!array_key_exists('name', $item))
                {
                    $item['name'] = $id;
                }
                $item['name'] = str_replace('__','_',$item['name']);
                if(!array_key_exists('type',$item))
                {
                    if(strpos($item['resource'],'.yml'))
                    {
                        $item['type'] = CG\Routing::TYPE_YML;
                    }
                    else

                        if(strpos($item['resource'],'.xml'))
                    {
                        $item['type'] = CG\Routing::TYPE_XML;
                    }
                    else
                    {
                        $item['type'] = CG\Routing::TYPE_ANNOTATION;
                    }
                }
                switch($item['type'])
                {
                    case CG\Routing::TYPE_ANNOTATION:
                        if(empty($item['resource']))
                        {
                            $item['resource'] = '@'.$item['baseClass'].'/'.$item['controllerPath'].'/';
                        }
                        $rowSet = [
                            'resource' => $item['resource'],
                            'type'=>$item['type'],
                        ];
                    break;
                    case CG\Routing::TYPE_XML:
                        if(empty($item['resource']))
                        {
                            $item['resource'] = '@'.$item['baseClass'].'/'.CG\Routing::BUNDLE_PATH_XML;
                        }
                        $rowSet = [
                            'resource' => $item['resource'],
                            'type'=>$item['type'],
                        ];
                    break;
                    case CG\Routing::TYPE_YML:
                        if(empty($item['resource']))
                        {
                            $item['resource'] = '@'.$item['baseClass'].'/'.CG\Routing::BUNDLE_PATH_YML;
                        }
                        $rowSet = [
                            'resource' => $item['resource'],
                            'type'=>$item['type'],
                        ];
                    break;
                }
                if(!empty($item['host']))
                {
                    $rowSet['host'] = $item['host'];
                }
                if(!empty($item['prefix']))
                {
                    $rowSet['prefix'] = $item['prefix'];
                }
                $returnSet[$item['name']] = $rowSet;
            }
        }
        return $returnSet;
    }

    /**
     * @param array            $production
     * @param array            $development
     * @param CG\Routing       $annotation
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return array
     */
    protected function processAnnotation(array $production, array $development, CG\Routing $annotation, \ReflectionClass $reflectionClass)
    {
        if(empty($annotation->getName()))
        {
            $namespace = $reflectionClass->getShortName();
            $namespace = strtolower(preg_replace('/(?|([a-z\d])([A-Z])|([^\^])([A-Z][a-z]))/', '$1_$2', $namespace));
            $namespace = str_replace('\\','_',$namespace);
            $annotation->setName($namespace);
        }
        if(!$annotation->isIgnore() && $annotation->isDevelopment())
        {
            $development[] = [
                'name'=>$annotation->getName(),
                'resource'=>$annotation->getResource(),
                'prefix'=>$annotation->getPrefix(),
                'host'=>$annotation->getHost(),
                'type'=>$annotation->getType(),
                'baseClass'=>$reflectionClass->getShortName(),
                'controllerPath'=>$annotation->getControllerPath(),
            ];
        }
        else
            if($annotation->isDevelopment() === false && $annotation->isIgnore() === false)
        {
            $production[] = [
                'name'=>$annotation->getName(),
                'resource'=>$annotation->getResource(),
                'prefix'=>$annotation->getPrefix(),
                'host'=>$annotation->getHost(),
                'type'=>$annotation->getType(),
                'baseClass'=>$reflectionClass->getShortName(),
                'controllerPath'=>$annotation->getControllerPath(),
            ];
        }
        return [$production, $development];
    }

    /**
     * @return KernelInterface
     */
    public function getKernel(): KernelInterface
    {
        return $this->kernel;
    }

    /**
     * @return ReadAnnotationService
     */
    public function getAnnotationService(): ReadAnnotationService
    {
        return $this->annotationService;
    }

    /**
     * @return array
     */
    public function getRoutingFile(): array
    {
        return $this->routingFile;
    }

    /**
     * @return bool
     */
    public function isCleanup(): bool
    {
        return $this->cleanup;
    }

    /**
     * @return ConfiguratorService
     */
    public function getConfiguration(): ConfiguratorService
    {
        return $this->configuration;
    }

    /**
     * @param bool $cleanup
     *
     * @return RouteGenerator
     */
    public function setCleanup(bool $cleanup): RouteGenerator
    {
        $this->cleanup = $cleanup;
        return $this;
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * @return EventDispatcherService
     */
    public function getEventDispatcherService(): EventDispatcherService
    {
        return $this->eventDispatcherService;
    }

    /**
     * @return EventDispatcherService
     */
    public function getED():EventDispatcherService
    {
        return $this->getEventDispatcherService();
    }
}
