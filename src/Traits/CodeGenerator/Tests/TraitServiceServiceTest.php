<?php
declare(strict_types = 1); /**
 * Automatically created file
 * Changes will be overwritten on AutoGenerator Run!
 */
 namespace MjrOne\CodeGeneratorBundle\Traits\CodeGenerator\Tests;
use MjrOne\CodeGeneratorBundle\Annotation as CG;
use Spectware\FrameworkBundle\Core\Response;
use Spectware\FrameworkBundle\Core\Request;
use Spectware\FrameworkBundle\Core\RedirectResponse;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig_Environment;
use Spectware\FrameworkBundle\Services\CacheService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;
use \MjrOne\CodeGeneratorBundle\Services\RenderService;

/**
 * TraitServiceServiceTest
 * @author    Chris Westerfield <chris@mjr.one>
 * @package   MjrOne\CodeGeneratorBundle\Traits\CodeGenerator\Tests
 * @link      https://www.mjr.one
 * @copyright copyright (c) by Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 * @method test(string $test, string $test2)
 * @method setTest2(string $test);
 * @method test33(string $test3)
 * Generatored by MJR.ONE CodeGenerator Bundle (Generator Copyright (c) by Chris Westerfield 2017, Licensed under LGPL V3) - Version 1.0.0
 * Last Update: 20.03.2017 - 23:40:42
 */

trait TraitServiceServiceTest
{
    /**
     * ServiceTest::__construct()
     * Trait and ServiceTest Constructor
     * @param Twig_Environment $twig
     * @param Router $router
     * @param CacheService $cache
     * @param EventDispatcherInterface $event
     * @param EntityManager $em
     * @param \MjrOne\CodeGeneratorBundle\Services\RenderService $test3
     */
    public function __construct(Twig_Environment $twig, Router $router, CacheService $cache, EventDispatcherInterface $event, EntityManager $em, \MjrOne\CodeGeneratorBundle\Services\RenderService $test3)
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->cache = $cache;
        $this->event = $event;
        $this->em = $em;
        $this->test33($test3);
        $this->test($test, $test2);
    }


        /**
     * @var \Twig_Environment
     * @CG\Mutator\Property(ignore=true)
     */
    protected $twig;

    /**
     * Render Using Twig Template Engine
     * @param $view
     * @param array $parameters
     * @param Response|null $response
     * @return Response
     * @throws \UnexpectedValueException
     */
    protected function renderTwig($view, array $parameters = array(), Response $response = null):Response    {
        if($response === null)
        {
            $response = new Response();
        }
        $response->setContent($this->twig->render($view,$parameters));
        return $response;
    }
        /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     * @CG\Mutator\Property(ignore=true)
     */
    protected $router;

    /**
     * Generates a URL from the given parameters.
     *
     * @param string $route         The name of the route
     * @param mixed  $parameters    An array of parameters
     * @param int    $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     *
     * @return string The generated URL
     *
     * @see UrlGeneratorInterface
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH):UrlGeneratorInterface    {
        return $this->router->generate($route, $parameters, $referenceType);
    }

    /**
     * Returns a RedirectResponse to the given URL.
     *
     * @param string $url    The URL to redirect to
     * @param int    $status The status code to use for the Response
     *
     * @return RedirectResponse
     * @throws \InvalidArgumentException
     */
    protected function redirect($url, $status = 302):RedirectResponse    {
        return new RedirectResponse($url, $status);
    }

    /**
     * Returns a RedirectResponse to the given route with the given parameters.
     *
     * @param string $route      The name of the route
     * @param array  $parameters An array of parameters
     * @param int    $status     The status code to use for the Response
     *
     * @return RedirectResponse
     * @throws \InvalidArgumentException
     */
    protected function redirectToRoute($route, array $parameters = array(), $status = 302):RedirectResponse    {
        return $this->redirect($this->generateUrl($route, $parameters), $status);
    }

    /**
     * post redirect
     * @param $route
     * @param array $variables
     * @return RedirectResponse
     */
    protected function redirectPost($route,array $variables=[]):RedirectResponse    {
        return $this->redirectToRoute($route,$variables,307);
    }
    
    /**
     * get Current Url
     * @param Request $request
     * @return string
     */
    protected function getCurrentUrl(Request $request):string    {
        return 'http'.($request->server->has('HTTPS')&&$request->server->get('HTTPS')==='on'?'s':'')
              .'://'.$request->server->get('SERVER_NAME');
    }
        /**
     * @var CacheService
     * @CG\Mutator\Property(ignore=true)
     */

    protected $cache;

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getCacheEntry($key)
    {
        return $this->getCache()->get($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     *
     * @return $this
     */
    public function setCache($key, $value,int $ttl=86400)
    {
        $this->getCache()->set($key, $value, $ttl);
        return $this;
    }

    /**
     * @return CacheService
     */
    public function getCache():CacheService    {
        return $this->cache;
    }
    
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     * @CG\Mutator\Property(ignore=true)
     */
    protected $event;

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getEvent():\Symfony\Component\EventDispatcher\EventDispatcherInterface
    {
        return $this->event;
    }
        /**
     * @var EntityManager
     * @CG\Mutator\Property(ignore=true)
     */

    protected $entityManager;

    /**
     * @return EntityManager
     */
    public function getEntityManager():EntityManager    {
        return $this->entityManager;
    }
    }
