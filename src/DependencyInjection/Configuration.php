<?php
namespace MjrOne\CodeGeneratorBundle\DependencyInjection;
use Kassko\Util\MemberAccessor\ObjectMemberAccessor;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class Configuration
 *
 * @package MjrOne\CodeGeneratorBundle\DependencyInjection
 * @author    Chris Westerfield <chris@mjr.one>
 * @link      https://www.mjr.one
 * @copyright Christopher Westerfield MJR.ONE
 * @license   GNU Lesser General Public License
 */
class Configuration implements ConfigurationInterface
{
    /**
     * get Config Tree
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->root('mjr_one_code_generator');
        $rootNode
            ->children()
                ->scalarNode('entity_interface_class')
                    ->defaultValue('\MjrOne\CodeGeneratorInterfaces\EntityInterface')
                ->end()
                ->arrayNode('cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultValue(false)
                        ->end()
                        ->scalarNode('class')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('class_short')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('service')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('event')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')
                            ->defaultValue('\Symfony\Component\EventDispatcher\EventDispatcherInterface')
                        ->end()
                        ->scalarNode('class_short')
                            ->defaultValue('EventDispatcherInterface')
                        ->end()
                        ->scalarNode('service')
                            ->defaultValue('@event_dispatcher')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('core')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('responseClass')
                            ->defaultValue('Symfony\Component\HttpFoundation\Response')
                        ->end()
                        ->scalarNode('requestClass')
                            ->defaultValue('Symfony\Component\HttpFoundation\Request')
                        ->end()
                        ->scalarNode('redirectClass')
                            ->defaultValue('Symfony\Component\HttpFoundation\RedirectResponse')
                        ->end()
                        ->scalarNode('AppKernel')
                            ->defaultValue('Symfony\Component\HttpKernel\KernelInterface')
                        ->end()
                    ->end()
                ->end();
        $this->addRouterNodeConfiguration($rootNode);
        $this->addFileDefinitions($rootNode);
        $this->addUserDefinitions($rootNode);
        return $treeBuilder;
    }

    /**
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $rootNode
     */
    public function addUserDefinitions(ArrayNodeDefinition $rootNode):void
    {
        $rootNode
            ->children()
                ->arrayNode('user')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('factory_class')
                            ->defaultValue('\MJR\UserBundle\Services\CurrentUserFactory')
                        ->end()
                        ->scalarNode('factory_class_short')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('factory_service')
                            ->defaultValue('@mjr.user_bundle.services.current_user_factory')
                        ->end()
                        ->scalarNode('repository_service')
                            ->defaultValue('@mjr.user_bundle.repository.user_repository')
                        ->end()
                        ->scalarNode('entity')
                            ->defaultValue('MJR\UserBundle\Entity\User')
                        ->end()
                        ->scalarNode('entity_short')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }


    /**
     * @param ArrayNodeDefinition $rootNode
     */
    public function addFileDefinitions(ArrayNodeDefinition $rootNode):void
    {
        $rootNode
            ->children()
                ->arrayNode('file_properties')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('hide_generated_by')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('copyright')
                            ->defaultValue('Christopher Westerfield')
                        ->end()
                        ->scalarNode('license')
                            ->defaultValue('MJR.ONE L-GPL V3')
                        ->end()
                        ->booleanNode('use_strict_types')
                            ->defaultValue(true)
                        ->end()
                        ->booleanNode('use_namespace')
                            ->defaultValue(true)
                        ->end()
                        ->scalarNode('link')
                            ->defaultValue('https://www.mjr.one')
                        ->end()
                        ->arrayNode('authors')
                            ->defaultValue([['author'=>'Christopher Westerfield','email'=>'chris@mjr.one']])
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('name')
                                        ->defaultValue('Christopher Westerfield')
                                    ->end()
                                    ->scalarNode('email')
                                        ->defaultValue('chris@mjr.one')
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }


    /**
     * @param ArrayNodeDefinition $rootNode
     */
    public function addRouterNodeConfiguration(ArrayNodeDefinition $rootNode):void
    {
        $rootNode
            ->children()
                ->arrayNode('router')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('bundles')
                        ->defaultValue('config/routing.yml')
                    ->end()
                    ->scalarNode('development')
                        ->defaultValue('config/routing_dev.yml')
                    ->end()
                    ->arrayNode('BaseRoutes')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('production')
                                ->defaultValue([])
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                        ->end()
                                        ->scalarNode('resource')
                                            ->defaultNull()
                                        ->end()
                                        ->scalarNode('prefix')
                                            ->defaultNull()
                                        ->end()
                                        ->scalarNode('type')
                                            ->defaultValue('annotation')
                                        ->end()
                                        ->scalarNode('host')
                                            ->defaultNull()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('development')
                                ->defaultValue(
                                   [
                                       [
                                            'name'=>'_wdt',
                                            'resource'=>'@WebProfilerBundle/Resources/config/routing/wdt.xml',
                                            'prefix'=>'/_wdt',
                                            'type'=>'xml',
                                       ],
                                       [
                                           'name'=>'_profiler',
                                           'resource'=>'@WebProfilerBundle/Resources/config/routing/profiler.xml',
                                           'prefix'=>'/_profiler',
                                           'type'=>'xml',
                                       ],
                                       [
                                           'name'=>'_errors',
                                           'resource'=>'@TwigBundle/Resources/config/routing/errors.xml',
                                           'prefix'=>'/_error',
                                           'type'=>'xml',
                                       ],
                                       [
                                           'name'=>'_master',
                                           'resource'=>'routing.yml',
                                           'type'=>'reference',
                                       ],
                                    ]
                                )
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                        ->end()
                                        ->scalarNode('resource')
                                            ->defaultNull()
                                        ->end()
                                        ->scalarNode('prefix')
                                            ->defaultNull()
                                        ->end()
                                        ->scalarNode('type')
                                            ->defaultValue('annotation')
                                        ->end()
                                        ->scalarNode('host')
                                            ->defaultNull()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }
}
