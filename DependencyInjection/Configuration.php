<?php

namespace Tristanbes\ElophantBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tristanbes_elophant');

        $rootNode
            ->children()
                ->arrayNode('elophant')
                    ->children()
                        ->scalarNode('base_url')->isRequired()->end()
                        ->scalarNode('api_key')->isRequired()->end()
                        ->scalarNode('cache_ttl')
                            ->isRequired()
                            ->info('A value too small will increase the chance that your application reach the API request limitation, in opposit, a value too high will delay the statistics update')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('dashboard')
                    ->children()
                        ->integerNode('max_days')
                            ->isRequired()
                            ->defaultValue(30)
                            ->info('Number of day that you can vizualise in your dashboard')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
