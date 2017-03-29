<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation\Service;

use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;
use MjrOne\CodeGeneratorBundle\Annotation\ClassInterface;
use MjrOne\CodeGeneratorBundle\Annotation\DriverInterface;
use MjrOne\CodeGeneratorBundle\Annotation\SubDriverInterface;
use MjrOne\CodeGeneratorBundle\Generator\Driver\Service\ServiceInjectionGenerator;

/**
 * Class Service
 *
 * @package   CodeGeneratorBundle\Annotation\Service
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license   LGPL V3
 * @link      http://www.mjr.one
 * @author    Chris Westerfield <chris@mjr.one>
 * @package   CodeGeneratorBundle\Annotation\SubDriverInterface
 * @Annotation
 * @Target({"CLASS"})
 */
final class Injection extends AbstractAnnotation implements ClassInterface, ServiceInterface, SubDriverInterface
{
    const DRIVER = ServiceInjectionGenerator::class;
    /**
     * @var bool
     */
    public $flash = false;

    /**
     * @var bool
     */
    public $string = false;

    /**
     * @var bool
     */
    public $stream = false;

    /**
     * @var bool
     */
    public $template = false;

    /**
     * @var bool
     */
    public $twig = false;

    /**
     * @var bool
     */
    public $session = false;

    /**
     * @var bool
     */
    public $router = false;

    /**
     * @var bool
     */
    public $json = false;

    /**
     * @var bool
     */
    public $form = false;

    /**
     * @var bool
     */
    public $url = false;

    /**
     * @var bool
     */
    public $user = false;

    /**
     * @var bool
     */
    public $cache = false;

    /**
     * @var bool
     */
    public $event = false;

    /**
     * @var bool
     */
    public $em = false;

    /**
     * @var bool
     */
    public $translator = false;

    /**
     * @var bool
     */
    public $container = false;

    /**
     * @var bool
     */
    public $cookie = false;

    /**
     * @var bool
     */
    public $render = false;

    /**
     * @var bool
     */
    public $renderView = false;

    /**
     * @var bool bool
     */
    public $forward = false;

    /**
     * @var bool
     */
    public $grant = false;

    /**
     * @var bool
     */
    public $binaryReturn = false;

    /**
     * @var bool
     */
    public $csrfToken = false;

    /**
     * @var bool
     */
    public $userFactory = false;

    /**
     * @var bool
     */
    public $kernel = false;

    /**
     * @var bool
     */
    public $parameters = false;

    /**
     * @var bool
     */
    public $responseFactory = false;

    /**
     * @return bool
     */
    public function isResponseFactory(): bool
    {
        return $this->responseFactory;
    }

    /**
     * @param bool $responseFactory
     *
     * @return Injection
     */
    public function setResponseFactory(bool $responseFactory): Injection
    {
        $this->responseFactory = $responseFactory;

        return $this;
    }

    /**
     * @return bool
     */
    public function isKernel(): bool
    {
        return $this->kernel;
    }

    /**
     * @param bool $kernel
     *
     * @return Injection
     */
    public function setKernel(bool $kernel): Injection
    {
        $this->kernel = $kernel;

        return $this;
    }

    /**
     * @return bool
     */
    public function isParameters(): bool
    {
        return $this->parameters;
    }

    /**
     * @param bool $parameters
     *
     * @return Injection
     */
    public function setParameters(bool $parameters): Injection
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUserFactory(): bool
    {
        return $this->userFactory;
    }

    /**
     * @param bool $userFactory
     */
    public function setUserFactory(bool $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    /**
     * @return bool
     */
    public function isCsrfToken(): bool
    {
        return $this->csrfToken;
    }

    /**
     * @param bool $csrfToken
     *
     * @return Injection
     */
    public function setCsrfToken(bool $csrfToken): Injection
    {
        $this->csrfToken = $csrfToken;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBinaryReturn(): bool
    {
        return $this->binaryReturn;
    }

    /**
     * @param bool $binaryReturn
     *
     * @return Injection
     */
    public function setBinaryReturn(bool $binaryReturn): Injection
    {
        $this->binaryReturn = $binaryReturn;

        return $this;
    }

    /**
     * @return bool
     */
    public function isGrant(): bool
    {
        return $this->grant;
    }

    /**
     * @param bool $grant
     *
     * @return Injection
     */
    public function setGrant(bool $grant): Injection
    {
        $this->grant = $grant;

        return $this;
    }


    /**
     * @return bool
     */
    public function isForward(): bool
    {
        return $this->forward;
    }

    /**
     * @param bool $forward
     *
     * @return Injection
     */
    public function setForward(bool $forward): Injection
    {
        $this->forward = $forward;

        return $this;
    }


    /**
     * @return bool
     */
    public function isRenderView(): bool
    {
        return $this->renderView;
    }

    /**
     * @param bool $renderView
     *
     * @return Injection
     */
    public function setRenderView(bool $renderView): Injection
    {
        $this->renderView = $renderView;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRender(): bool
    {
        return $this->render;
    }

    /**
     * @param bool $render
     *
     * @return Injection
     */
    public function setRender(bool $render): Injection
    {
        $this->render = $render;

        return $this;
    }

    /**
     * @return bool
     */
    public function getFlash()
    {
        return $this->flash;
    }

    public function isFlash()
    {
        return $this->flash;
    }

    /**
     * @param bool $flash
     *
     * @return Injection
     */
    public function setFlash(bool $flash): Injection
    {
        $this->flash = $flash;

        return $this;
    }

    /**
     * @return bool
     */
    public function getString()
    {
        return $this->string;
    }

    public function isString()
    {
        return $this->string;
    }

    /**
     * @param bool $string
     *
     * @return Injection
     */
    public function setString(bool $string): Injection
    {
        $this->string = $string;

        return $this;
    }

    /**
     * @return bool
     */
    public function getStream()
    {
        return $this->stream;
    }

    public function isStream()
    {
        return $this->stream;
    }

    /**
     * @param bool $stream
     *
     * @return Injection
     */
    public function setStream(bool $stream): Injection
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * @return bool
     */
    public function getTemplate()
    {
        return $this->template;
    }

    public function isTemplate()
    {
        return $this->template;
    }

    /**
     * @param bool $template
     *
     * @return Injection
     */
    public function setTemplate(bool $template): Injection
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return bool
     */
    public function getTwig()
    {
        return $this->twig;
    }

    public function isTwig()
    {
        return $this->twig;
    }

    /**
     * @param bool $twig
     *
     * @return Injection
     */
    public function setTwig(bool $twig): Injection
    {
        $this->twig = $twig;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSession()
    {
        return $this->session;
    }

    public function isSession()
    {
        return $this->session;
    }

    /**
     * @param bool $session
     *
     * @return Injection
     */
    public function setSession(bool $session): Injection
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return bool
     */
    public function getRouter()
    {
        return $this->router;
    }

    public function isRouter()
    {
        return $this->router;
    }

    /**
     * @param bool $router
     *
     * @return Injection
     */
    public function setRouter(bool $router): Injection
    {
        $this->router = $router;

        return $this;
    }

    /**
     * @return bool
     */
    public function getJson()
    {
        return $this->json;
    }

    public function isJson()
    {
        return $this->json;
    }

    /**
     * @param bool $json
     *
     * @return Injection
     */
    public function setJson(bool $json): Injection
    {
        $this->json = $json;

        return $this;
    }

    /**
     * @return bool
     */
    public function getForm()
    {
        return $this->form;
    }

    public function isForm()
    {
        return $this->form;
    }

    /**
     * @param bool $form
     *
     * @return Injection
     */
    public function setForm(bool $form): Injection
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return bool
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function isUrl()
    {
        return $this->url;
    }

    /**
     * @param bool $url
     *
     * @return Injection
     */
    public function setUrl(bool $url): Injection
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->user;
    }

    /**
     * @param bool $user
     *
     * @return Injection
     */
    public function setUser(bool $user): Injection
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCache()
    {
        return $this->cache;
    }

    public function isCache()
    {
        return $this->cache;
    }

    /**
     * @param bool $cache
     *
     * @return Injection
     */
    public function setCache(bool $cache): Injection
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return bool
     */
    public function getEvent()
    {
        return $this->event;
    }

    public function isEvent()
    {
        return $this->event;
    }

    /**
     * @param bool $event
     *
     * @return Injection
     */
    public function setEvent(bool $event): Injection
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return bool
     */
    public function getEm()
    {
        return $this->em;
    }

    public function isEm()
    {
        return $this->em;
    }

    /**
     * @param bool $em
     *
     * @return Injection
     */
    public function setEm(bool $em): Injection
    {
        $this->em = $em;

        return $this;
    }

    /**
     * @return bool
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    public function isTranslator()
    {
        return $this->translator;
    }

    /**
     * @param bool $translator
     *
     * @return Injection
     */
    public function setTranslator(bool $translator): Injection
    {
        $this->translator = $translator;

        return $this;
    }

    /**
     * @return bool
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function isContainer()
    {
        return $this->container;
    }

    /**
     * @param bool $container
     *
     * @return Injection
     */
    public function setContainer(bool $container): Injection
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    public function isCookie()
    {
        return $this->cookie;
    }

    /**
     * @param bool $cookie
     *
     * @return Injection
     */
    public function setCookie(bool $cookie): Injection
    {
        $this->cookie = $cookie;

        return $this;
    }
}
