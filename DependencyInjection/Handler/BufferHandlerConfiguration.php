<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class BufferHandlerConfiguration extends AbstractHandlerConfiguration
{
    static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->scalarNode('handler')->end() // buffer
                ->scalarNode('buffer_size')->defaultValue(0)->end() // buffer
                ->booleanNode('flush_on_overflow')->defaultFalse()->end() // buffer
            ->end()
        ;

        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'buffer' === $v['type'] && empty($v['handler']); })
                    ->thenInvalid('The handler has to be specified to use a BufferHandler')
                ->end()
            ;
        }

    }

    public function getType(): HandlerType
    {
        return HandlerType::BUFFER;
    }
}
