<?php
declare(strict_types = 1);
/**
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Spectware, Inc.
 * @license   GNU Lesser General Public License
 * Created by PhpStorm.
 * User: cwesterfield
 * Date: 18/03/2017
 * Time: 13:18
 */

namespace MjrOne\CodeGeneratorBundle\Services\Driver\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\ServiceInjectionGeneratorEvent;
use MjrOne\CodeGeneratorBundle\Services\Configuration\User;
use MjrOne\CodeGeneratorBundle\Services\Driver\SubDriverInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\PhpEngine;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Translation\TranslatorInterface;
use Twig_Environment;

class ServiceInjectionGenerator extends SubGeneratorAbstract implements SubDriverInterface
{
    /**
     * @var array
     */
    protected $serviceMap = [];

    protected $serviceConfigMap = [];

    protected $userFactoryEnabled;

    /**
     * @return void
     */
    public function process(): void
    {
        $this->prepareMaps();
        $this->templateVariables->set('injectedServices', $this->generateService());
        $event = (new ServiceInjectionGeneratorEvent())->setConfig($this->config)->setTemplateVars($this->templateVariables)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'preProcess'),$event);
        $this->templateVariables = $event->getTemplateVars();
        $this->config = $event->getConfig();

        $this->processConfigs($this->templateVariables->get('injectedServices'));
        $event = (new ServiceInjectionGeneratorEvent())->setConfig($this->config)->setTemplateVars($this->templateVariables)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'processConfig'),$event);
        $this->templateVariables = $event->getTemplateVars();
        $this->config = $event->getConfig();

        $this->processInjections($this->templateVariables->get('injectedServices'));
        $event = (new ServiceInjectionGeneratorEvent())->setConfig($this->config)->setTemplateVars($this->templateVariables)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'processInjections'),$event);
        $this->templateVariables = $event->getTemplateVars();

        $this->config = $event->getConfig();
        $event = (new ServiceInjectionGeneratorEvent())->setConfig($this->config)->setTemplateVars($this->templateVariables)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'getConfig'),$event);
        $this->templateVariables = $event->getTemplateVars();
        $this->config = $event->getConfig();

        $this->addUseList();
        $event = (new ServiceInjectionGeneratorEvent())->setConfig($this->config)->setTemplateVars($this->templateVariables)->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class,'addUseList'),$event);
        $this->templateVariables = $event->getTemplateVars();
        $this->config = $event->getConfig();
    }

    /**
     * @return bool
     */
    protected function isUserFactoryEnabled()
    {
        if($this->userFactoryEnabled === null)
        {
            $this->userFactoryEnabled = $this->getService()->getConfig()->getUser() instanceof User
                                        && $this->getService()->getConfig()->getUser()->isEnabled();
        }
        return $this->userFactoryEnabled;
    }

    /**
     * @return string
     */
    protected function getUserFactory()
    {
        if($this->isUserFactoryEnabled())
        {
            return '@' . $this->getService()->getConfig()->getUser()->getFactoryService();
        }
        else
        {
            return '';
        }
    }

    /**
     * @param array                                                    $services
     * @param \MjrOne\CodeGeneratorBundle\Annotation\Service\Injection $annotation
     */
    protected function getFlash(array &$services,CG\Service\Injection $annotation)
    {
        if ($annotation->isFlash())
        {
            $services['session'] = true;
            $services['flash'] = true;
        }
    }

    /**
     * @param array                                                    $services
     * @param \MjrOne\CodeGeneratorBundle\Annotation\Service\Injection $annotation
     */
    public function getRender(array &$services,CG\Service\Injection $annotation)
    {
        $services['render'] = $annotation->isRender();
        if ($annotation->isRender())
        {
            if (!$services['twig'] && !$services['template'])
            {
                $services['twig'] = true;
            }
        }
        $services['renderView'] = $annotation->isRenderView();
        if ($annotation->isRenderView())
        {
            if (!$services['twig'] && !$services['template'])
            {
                $services['twig'] = true;
            }
        }
        $services['twig'] = $annotation->isTwig();
        $services['template'] = $annotation->isTemplate();
        if ($annotation->isTemplate())
        {
            $services['twig'] = true;
        }
        $services['stream'] = $annotation->isStream();
        if ($annotation->isStream())
        {
            if (!$services['twig'] && !$services['template'])
            {
                $services['twig'] = true;
            }
        }
    }

    /**
     * @return array
     */
    protected function generateService()
    {
        $this->serviceMap['userFactory'] = $this->getUserFactory();
        $services = [];
        $annotation = $this->getAnnotation();
        /** @var CG\Service\Injection $annotation */
        $services['session'] = $annotation->isSession();
        $this->getFlash($services, $annotation);
        $services['string'] = $annotation->isString();
        $this->getRender($services, $annotation);
        $services['router'] = $annotation->isRouter();
        $services['json'] = $annotation->isJson();
        $services['form'] = $annotation->isForm();
        $services['url'] = $annotation->isUrl();
        $services['userFactory'] = $annotation->isUser();
        $services['cache'] = $annotation->isCache();
        $services['event'] = $annotation->isEvent();
        $services['em'] = $annotation->isEm();
        $services['translator'] = $annotation->isTranslator();
        $services['container'] = $annotation->isContainer();
        $services['cookie'] = $annotation->isCookie();
        $services['forward'] = $annotation->isForward();
        $services['granted'] = $annotation->isGrant();
        if ($annotation->isGrant() || $annotation->isForward() || $annotation->isCsrfToken() || $annotation->isParameters())
        {
            $services['container'] = true;
        }
        $services['binary'] = $annotation->isBinaryReturn();
        $services['csrfToken'] = $annotation->isCsrfToken();
        $services['kernel'] = $annotation->isKernel();
        $services['parameters'] = $annotation->isParameters();
        $services['userFactory'] = $this->isUserFactoryEnabled() && $annotation->isUserFactory();
        if ($services['render'] || $services['renderView'] || $services['stream'] || $services['router']
            || $services['forward']
            || $services['cookie']
            || $services['binary']
            || $services['json']
            || $annotation->isResponseFactory()
        )
        {
            $services['responseFactory'] = true;
        }
        else
        {

            $services['responseFactory'] = false;
        }
        return $services;
    }

    /**
     * @param $services
     */
    protected function processConfigs($services)
    {
        foreach ($services as $service => $value)
        {
            if (array_key_exists($service, $this->serviceMap) && $value)
            {
                $this->config['services'][$this->templateVariables->get('serviceName')]['arguments'][] =
                    $this->serviceMap[$service];
            }
        }
    }

    /**
     * @param $services
     */
    protected function processInjections($services)
    {
        $injections = [];
        if (!empty($services))
        {
            foreach ($services as $service => $active)
            {
                if ($active && array_key_exists($service,$this->serviceConfigMap))
                {
                    $injections[] = $this->serviceConfigMap[$service];
                }
            }
        }
        $this->templateVariables->set('injections',$injections);
    }

    /**
     *
     */
    protected function prepareMaps()
    {
        $this->serviceMap = [
            'session'    => '@session',
            'router'     => '@router',
            'template'   => '@templating.engine.php',
            'twig'       => '@twig',
            'form'       => '@form.factory',
            'user'       => '@security.token_storage',
            'cache'      => $this->getService()->getConfig()->getCache()->getService(),
            'event'      => $this->getService()->getConfig()->getEvent()->getService(),
            'em'         => '@doctrine.orm.entity_manager',
            'translator' => '@translator',
            'container'  => '@service_container',
            'kernel'     => '@kernel',
        ];
        $this->serviceConfigMap = [
            'session' => [
                'name'  => 'session',
                'class' => 'Session',
            ],
            'router'=>[
                'name'=>'router',
                'class'=>'Router',
            ],
            'template'=>[
                'name'=>'templating',
                'class'=>'PhpEngine',
            ],
            'twig'=>[
                'name'=>'twig',
                'class'=>'Twig_Environment',
            ],
            'form'=>[
                'name'=>'form',
                'class'=>'FormFactory',
            ],
            'user'=>[
                'name'=>'user',
                'class'=>$this->getService()->getConfig()->getUser()->getEntityShort(),
            ],
            'cache'=>[
                'name'=>'cache',
                'class'=>$this->getService()->getConfig()->getCache()->getClassShort(),
            ],
            'event'=>[
                'name'=>'event',
                'class'=>'EventDispatcherInterface',
            ],
            'em'=>[
                'name'=>'em',
                'class'=>'EntityManager',
            ],
            'translator'=>[
                'name'=>'translator',
                'class'=>'TranslatorInterface',
            ],
            'container'=>[
                'name'=>'container',
                'class'=>'Container',
            ],
            'kernel'=>[
                'name'=>'kernel',
                'class'=>$this->getService()->getConfig()->getCore()->getKernel(),
            ],
        ];
    }

    /**
     *
     */
    protected function addUseList()
    {
        /** @var ArrayCollection $list */
        $list = $this->templateVariables->get('useList');
        /** @var array $services */
        $services = $this->templateVariables->get('injectedServices');
        if((array_key_exists('router',$services) && $services['router']===true)||(array_key_exists('url',$services) && $services['url']===true))
        {
            $this->addToList(Router::class,$list);
            $this->addToList(UrlGeneratorInterface::class,$list);
        }
        if(array_key_exists('session',$services) && $services['session']===true)
        {
            $this->addToList(Session::class,$list);
        }
        if(array_key_exists('kernel',$services) && $services['kernel']===true)
        {
            $this->addToList($this->getService()->getConfig()->getCore()->getKernel(),$list);
        }
        if(array_key_exists('form',$services) && $services['form']===true)
        {
            $this->addToList(FormType::class,$list);
            $this->addToList(FormBuilder::class,$list);
            $this->addToList(Form::class,$list);
            $this->addToList(FormFactory::class,$list);
        }
        if(array_key_exists('template',$services) && $services['template']===true)
        {
            $this->addToList(PhpEngine::class,$list);
        }
        if(array_key_exists('twig',$services) && $services['twig']===true)
        {
            $this->addToList(Twig_Environment::class,$list);
        }
        if(array_key_exists('stream',$services) && $services['stream']===true)
        {
            $this->addToList(StreamedResponse::class,$list);
        }
        if((array_key_exists('user',$services) && $services['user']===true) || (array_key_exists('userFactory',$services) && $services['userFactory']===true))
        {
            $this->addToList($this->getService()->getConfig()->getUser()->getFactoryClass(),$list);
            $this->addToList($this->getService()->getConfig()->getUser()->getEntity(),$list);
            $this->addToList(TokenStorage::class,$list);
        }
        if(array_key_exists('cache',$services) && $services['cache']===true)
        {
            $this->addToList($this->getService()->getConfig()->getCache()->getClass(),$list);
        }
        if(array_key_exists('event',$services) && $services['event']===true)
        {
            $this->addToList(EventDispatcherInterface::class,$list);
        }
        if(array_key_exists('em',$services) && $services['em']===true)
        {
            $this->addToList(EntityManager::class,$list);
        }
        if(array_key_exists('translator',$services) && $services['translator']===true)
        {
            $this->addToList(TranslatorInterface::class,$list);
        }
        if(array_key_exists('container',$services) && $services['container']===true)
        {
            $this->addToList(Container::class,$list);
        }
        if(array_key_exists('binary',$services) && $services['binary']===true)
        {
            $this->addToList(BinaryFileResponse::class,$list);
        }
        $this->templateVariables->set('useList',$list);
    }
}