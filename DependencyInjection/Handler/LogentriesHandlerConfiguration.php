<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class LogentriesHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('token')->end() // logentries
                ->booleanNode('use_ssl')->defaultTrue()->end() // logentries
                ->scalarNode('timeout')->end() // logentries
                ->scalarNode('connection_timeout')->end() // logentries
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::LOGENTRIES;
    }
}
