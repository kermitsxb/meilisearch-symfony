<?php

namespace MeiliSearch\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 *
 * @package MeiliSearch\Bundle\DependencyInjection
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('meili_search');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('prefix')
                    ->defaultValue(null)
                ->end()
                ->scalarNode('nbResults')
                    ->defaultValue(20)
                ->end()
                ->scalarNode('batchSize')
                    ->defaultValue(500)
                ->end()
                ->arrayNode('doctrineSubscribedEvents')
                    ->prototype('scalar')->end()
                    ->defaultValue(['postPersist', 'postUpdate', 'preRemove'])
                ->end()
                ->scalarNode('serializer')
                    ->defaultValue('serializer')
                ->end()
                ->arrayNode('indices')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('class')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->booleanNode('enable_serializer_groups')
                                ->info('When set to true, it will call normalize method with an extra groups parameter "groups" => [Searchable::NORMALIZATION_GROUP]')
                                ->defaultFalse()
                            ->end()
                            ->scalarNode('index_if')
                                ->info('Property accessor path (like method or property name) used to decide if an entry should be indexed.')
                                ->defaultNull()
                            ->end()
                            ->arrayNode('settings')
                                ->info('Configure indices settings, see: https://docs.meilisearch.com/guides/advanced_guides/settings.html')
                                ->arrayPrototype()
                                    ->variablePrototype()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
