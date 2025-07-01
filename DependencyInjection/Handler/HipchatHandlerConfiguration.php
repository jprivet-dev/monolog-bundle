<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class HipchatHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->scalarNode('room')->end() // hipchat
                ->scalarNode('message_format')->defaultValue('text')->end() // hipchat
                ->scalarNode('api_version')->defaultNull()->end() // hipchat
                ->scalarNode('notify')->defaultFalse()->end() // hipchat
                ->scalarNode('nickname')->defaultValue('Monolog')->end() // hipchat
                ->scalarNode('token')->end() // hipchat
                ->booleanNode('use_ssl')->defaultTrue()->end() // hipchat
                ->scalarNode('host')->defaultNull()->end() // hipchat
                ->scalarNode('timeout')->end() // hipchat
                 ->scalarNode('connection_timeout')->end() // hipchat
           ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::HIPCHAT;
    }
}
