<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class ServerlogHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->scalarNode('host')->defaultNull()->info('Server log host. ex: 127.0.0.1:9911')->end()
           ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::SERVER_LOG;
    }
}
