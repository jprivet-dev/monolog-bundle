<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class InsightopsHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->scalarNode('token')->end() // insightops
                ->scalarNode('region')->end() // insightops
                ->booleanNode('use_ssl')->defaultTrue()->end() // insightops
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::INSIGHTOPS;
    }
}
