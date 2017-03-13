<?php
namespace MjrOne\CodeGeneratorBundle\DependencyInjection;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Configuration
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @package CodeGeneratorBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * get Config Tree
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mjr_code_generator');

        return $treeBuilder;
    }
}
