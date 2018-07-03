<?php

namespace Sylake\AkeneoProducerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sylake_akeneo_producer');

        $rootNode
            ->children()
                ->scalarNode('scope')->defaultValue('ecommerce')->end()
                ->arrayNode('locales')
                    ->prototype('scalar')->end()
                    ->performNoDeepMerging()
                    ->defaultValue(['en_GB', 'de_DE'])
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
