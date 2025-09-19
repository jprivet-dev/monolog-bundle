<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class ElasticaHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->arrayNode('elasticsearch')
                    ->canBeUnset()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return ['id' => $v]; })
                    ->end()
                    ->children()
                        ->scalarNode('id')->end()
                        ->scalarNode('host')->info('Elastic search host name. Do not prepend with http(s)://.')->end()
                        ->scalarNode('port')->defaultValue(9200)->end()
                        ->scalarNode('transport')->defaultValue('Http')->end()
                        ->scalarNode('user')->defaultNull()->end()
                        ->scalarNode('password')->defaultNull()->end()
                    ->end()
                    ->validate()
                        ->ifTrue(function ($v) {
                            return !isset($v['id']) && !isset($v['host']);
                        })
                        ->thenInvalid('What must be set is either the host or the id.')
                    ->end()
                ->end()
                ->scalarNode('index')->defaultValue('monolog')->end() // elasticsearch & elastic_search & elastica
                ->scalarNode('document_type')->defaultValue('logs')->end() // elasticsearch & elastic_search & elastica
                ->scalarNode('ignore_error')->defaultValue(false)->end() // elasticsearch & elastic_search & elastica
            ->end()
        ;
}

    public function getType(): HandlerType
    {
        return HandlerType::ELASTICA;
    }
}
