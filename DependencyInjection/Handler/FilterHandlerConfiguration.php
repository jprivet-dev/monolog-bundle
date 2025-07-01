<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class FilterHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->scalarNode('handler')->info('The wrapped handler\'s name.')->end() // filter
                ->arrayNode('accepted_levels') // filter
                    ->canBeUnset()
                    ->prototype('scalar')->end()
                    ->info('List of levels to accept')
                ->end()
                ->scalarNode('min_level')->defaultValue('DEBUG')->info('Minimum level to accept (only used if accepted_levels not specified).')->end() // filter
                ->scalarNode('max_level')->defaultValue('EMERGENCY')->info('Maximum level to accept (only used if accepted_levels not specified).')->end() // filter
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::FILTER;
    }
}
