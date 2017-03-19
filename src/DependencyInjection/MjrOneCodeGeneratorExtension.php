<?php
namespace MjrOne\CodeGeneratorBundle\DependencyInjection;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * MjrOneCodeGeneratorExtension
 * @copyright Christopher Westerfield <chris@mjr.one>
 * @license LGPL V3
 * @link http://www.mjr.one
 * @package CodeGeneratorBundle\DependencyInjection
 */
class MjrOneCodeGeneratorExtension extends Extension
{
    /**
     * Load Configuration and set Parameters
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $container->setParameter('mjrone.codegenerator.configuration',$config);
    }
}
