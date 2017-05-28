<?php
declare(strict_types=1);

namespace MjrOne\CodeGeneratorBundle\Generator\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use MjrOne\CodeGeneratorBundle\Event\ServiceInjectionGeneratorEvent;
use MjrOne\CodeGeneratorBundle\Configuration\User;
use MjrOne\CodeGeneratorBundle\Generator\SubCodeGeneratorInterface;
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

/**
 * Class ServiceInjectionGenerator
 *
 * @package   MjrOne\CodeGeneratorBundle\Generator\Service
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class ServiceInjectionGenerator extends SubCodeGeneratorAbstract implements SubCodeGeneratorInterface
{
    /**
     * @var array
     */
    protected $serviceMap = [];

    /**
     * @var array
     */
    protected $serviceConfigMap = [];

    /**
     * @var bool
     */
    protected $userFactoryEnabled;

    /**
     * @return void
     */
    public function process(): void
    {
        $this->prepareMaps();
        $this->templateVariables->set('injectedServices', $this->generateService());
        $event =
            (new ServiceInjectionGeneratorEvent())->setConfig($this->config)->setTemplateVars($this->templateVariables)
                                                  ->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'preProcess'), $event);
        $this->templateVariables = $event->getTemplateVars();
        $this->config = $event->getConfig();

        $this->processConfigs($this->templateVariables->get('injectedServices'));
        $event =
            (new ServiceInjectionGeneratorEvent())->setConfig($this->config)->setTemplateVars($this->templateVariables)
                                                  ->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'processConfig'), $event);
        $this->templateVariables = $event->getTemplateVars();
        $this->config = $event->getConfig();

        $this->processInjections($this->templateVariables->get('injectedServices'));
        $event =
            (new ServiceInjectionGeneratorEvent())->setConfig($this->config)->setTemplateVars($this->templateVariables)
                                                  ->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'processInjections'), $event);
        $this->templateVariables = $event->getTemplateVars();

        $this->config = $event->getConfig();
        $event =
            (new ServiceInjectionGeneratorEvent())->setConfig($this->config)->setTemplateVars($this->templateVariables)
                                                  ->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'getConfig'), $event);
        $this->templateVariables = $event->getTemplateVars();
        $this->config = $event->getConfig();

        $this->addUseList();
        $event =
            (new ServiceInjectionGeneratorEvent())->setConfig($this->config)->setTemplateVars($this->templateVariables)
                                                  ->setSubject($this);
        $this->getED()->dispatch($this->getED()->getEventName(self::class, 'addUseList'), $event);
        $this->templateVariables = $event->getTemplateVars();
        $this->config = $event->getConfig();
    }

    /**
     * @return bool
     */
    protected function isUserFactoryEnabled(): bool
    {
        if ($this->userFactoryEnabled === null)
        {
            $this->userFactoryEnabled = $this->getService()->getConfig()->getUser() instanceof User
                                        && $this->getService()->getConfig()->getUser()->isEnabled();
        }

        return $this->userFactoryEnabled;
    }

    /**
     * @return string
     */
    protected function getUserFactory(): string
    {
        if ($this->isUserFactoryEnabled())
        {
            return '@' . $this->getService()->getConfig()->getUser()->getFactoryService();
        }

        return '';
    }

    /**
     * @param array                                                    $services
     * @param \MjrOne\CodeGeneratorBundle\Annotation\Service\Injection $annotation
     */
    protected function getFlash(array &$services, CG\Service\Injection $annotation): void
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
    public function getRender(array &$services, CG\Service\Injection $annotation): void
    {
        $services['render'] = $annotation->isRender();
        if ($annotation->isRender())
        {
            if ((!isset($services['twig'])||$services['twig']===false) && (!isset($services['template'])||$services['template']===false))
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
    protected function generateService(): array
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
        $services['user'] = $annotation->isUser();
        $services['userFactory'] = $annotation->isUser();
        $services['cache'] = $annotation->isCache();
        $services['event'] = $annotation->isEvent();
        $services['em'] = $annotation->isEm();
        $services['translator'] = $annotation->isTranslator();
        $services['container'] = $annotation->isContainer();
        $services['cookie'] = $annotation->isCookie();
        $services['forward'] = $annotation->isForward();
        $services['granted'] = $annotation->isGrant();
        if ($annotation->isGrant() || $annotation->isForward() || $annotation->isCsrfToken()
            || $annotation->isParameters()
        )
        {
            $services['container'] = true;
        }
        $services['binary'] = $annotation->isBinaryReturn();
        $services['csrfToken'] = $annotation->isCsrfToken();
        $services['kernel'] = $annotation->isKernel();
        $services['parameters'] = $annotation->isParameters();
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
    protected function processConfigs($services): void
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
    protected function processInjections($services): void
    {
        $injections = [];
        if (!empty($services))
        {
            foreach ($services as $service => $active)
            {
                if ($active && array_key_exists($service, $this->serviceConfigMap))
                {
                    $injections[] = $this->serviceConfigMap[$service];
                }
            }
        }
        $this->templateVariables->set('injections', $injections);
    }

    /**
     *
     */
    protected function prepareMaps(): void
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
            'session'    => [
                'name'  => 'session',
                'class' => 'Session',
            ],
            'router'     => [
                'name'  => 'router',
                'class' => 'Router',
            ],
            'template'   => [
                'name'  => 'templating',
                'class' => 'PhpEngine',
            ],
            'twig'       => [
                'name'  => 'twig',
                'class' => 'Twig_Environment',
            ],
            'form'       => [
                'name'  => 'form',
                'class' => 'FormFactory',
            ],
            'user'       => [
                'name'  => 'user',
                'class' => 'TokenStorageInterface',
            ],
            'cache'      => [
                'name'  => 'cache',
                'class' => $this->getService()->getConfig()->getCache()->getClassShort(),
            ],
            'event'      => [
                'name'  => 'event',
                'class' => 'EventDispatcherInterface',
            ],
            'em'         => [
                'name'  => 'em',
                'class' => 'EntityManager',
            ],
            'translator' => [
                'name'  => 'translator',
                'class' => 'TranslatorInterface',
            ],
            'container'  => [
                'name'  => 'container',
                'class' => 'Container',
            ],
            'kernel'     => [
                'name'  => 'kernel',
                'class' => $this->getService()->getConfig()->getCore()->getKernel(),
            ],
        ];
    }

    /**
     *
     */
    protected function addUseList(): void
    {
        /** @var ArrayCollection $list */
        $list = $this->templateVariables->get('useList');
        /** @var array $services */
        $services = $this->templateVariables->get('injectedServices');
        if ((array_key_exists('router', $services) && $services['router'] === true)
            || (array_key_exists(
                    'url', $services
                )
                && $services['url'] === true)
        )
        {
            $this->addToList(Router::class, $list);
            $this->addToList(UrlGeneratorInterface::class, $list);
        }
        if (array_key_exists('session', $services) && $services['session'] === true)
        {
            $this->addToList(Session::class, $list);
        }
        if (array_key_exists('kernel', $services) && $services['kernel'] === true)
        {
            $this->addToList($this->getService()->getConfig()->getCore()->getKernel(), $list);
        }
        if (array_key_exists('form', $services) && $services['form'] === true)
        {
            $this->addToList(FormType::class, $list);
            $this->addToList(FormBuilder::class, $list);
            $this->addToList(Form::class, $list);
            $this->addToList(FormFactory::class, $list);
        }
        if (array_key_exists('template', $services) && $services['template'] === true)
        {
            $this->addToList(PhpEngine::class, $list);
        }
        if (array_key_exists('twig', $services) && $services['twig'] === true)
        {
            $this->addToList(Twig_Environment::class, $list);
        }
        if (array_key_exists('stream', $services) && $services['stream'] === true)
        {
            $this->addToList(StreamedResponse::class, $list);
        }
        if (array_key_exists('user', $services) && $services['user'] === true)
        {
            $this->addToList($this->getService()->getConfig()->getUser()->getFactoryClass(), $list);
            $this->addToList($this->getService()->getConfig()->getUser()->getEntity(), $list);
            $this->addToList(TokenStorage::class, $list);
        }
        if (array_key_exists('cache', $services) && $services['cache'] === true)
        {
            $this->addToList($this->getService()->getConfig()->getCache()->getClass(), $list);
        }
        if (array_key_exists('event', $services) && $services['event'] === true)
        {
            $this->addToList(EventDispatcherInterface::class, $list);
        }
        if (array_key_exists('em', $services) && $services['em'] === true)
        {
            $this->addToList(EntityManager::class, $list);
        }
        if (array_key_exists('translator', $services) && $services['translator'] === true)
        {
            $this->addToList(TranslatorInterface::class, $list);
        }
        if (array_key_exists('container', $services) && $services['container'] === true)
        {
            $this->addToList(Container::class, $list);
        }
        if (array_key_exists('binary', $services) && $services['binary'] === true)
        {
            $this->addToList(BinaryFileResponse::class, $list);
        }
        $this->templateVariables->set('useList', $list);
    }
}
