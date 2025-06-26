<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class BufferHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('handler')->info('The wrapped handler\'s name.')->end() // buffer
                ->scalarNode('buffer_size')->defaultValue(0)->end() // buffer
                ->booleanNode('flush_on_overflow')->defaultFalse()->end() // buffer
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::BUFFER;
    }
}
