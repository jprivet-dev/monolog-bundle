<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class FilterHandlerConfiguration extends AbstractHandlerConfiguration
{
    static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->arrayNode('accepted_levels') // filter
                    ->canBeUnset()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('min_level')->defaultValue('DEBUG')->end() // filter
                ->scalarNode('max_level')->defaultValue('EMERGENCY')->end() // filter
            ->end()
        ;

        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'filter' === $v['type'] && empty($v['handler']); })
                    ->thenInvalid('The handler has to be specified to use a FilterHandler')
                ->end()
                ->validate()
                    ->ifTrue(function ($v) { return 'filter' === $v['type'] && 'DEBUG' !== $v['min_level'] && !empty($v['accepted_levels']); })
                    ->thenInvalid('You can not use min_level together with accepted_levels in a FilterHandler')
                ->end()
                ->validate()
                    ->ifTrue(function ($v) { return 'filter' === $v['type'] && 'EMERGENCY' !== $v['max_level'] && !empty($v['accepted_levels']); })
                    ->thenInvalid('You can not use max_level together with accepted_levels in a FilterHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::FILTER;
    }
}
