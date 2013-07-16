<?php

namespace Tristanbes\ElophantBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TristanbesElophantExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('tristanbes_elophant.api_key', $config['elophant']['api_key']);
        $container->setParameter('tristanbes_elophant.base_url', $config['elophant']['base_url']);
        $container->setParameter('tristanbes_elophant.cache_ttl', $config['elophant']['cache_ttl']);
        $container->setParameter('tristanbes_elophant.dashboard_max_days', $config['dashboard']['max_days']);
    }
}
