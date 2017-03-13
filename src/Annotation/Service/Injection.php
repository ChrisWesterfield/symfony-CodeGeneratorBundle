<?php
declare(strict_types = 1);
namespace MjrOne\CodeGeneratorBundle\Annotation\Service;
use MjrOne\CodeGeneratorBundle\Annotation\AbstractAnnotation;

/**
 * Class Service
 * @package CodeGeneratorBundle\Annotation\Service
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @package CodeGeneratorBundle\Annotation\ClassDefinition
 * @Annotation
 * @Target({"CLASS"})
 */
final class Injection extends AbstractAnnotation
{
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
    public function getUser()
    {
        return $this->user;
    }

    public function isUser()
    {
        return $this->user;
    }

    /**
     * @param bool $user
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
     * @return Injection
     */
    public function setCookie(bool $cookie): Injection
    {
        $this->cookie = $cookie;
        return $this;
    }
}
