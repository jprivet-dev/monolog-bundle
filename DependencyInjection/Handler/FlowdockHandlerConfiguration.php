<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class FlowdockHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->scalarNode('token')->end() // flowdock
                ->scalarNode('source')->end() // flowdock
            ->end()
        ;

        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'flowdock' === $v['type'] && empty($v['token']); })
                    ->thenInvalid('The token has to be specified to use a FlowdockHandler')
                ->end()
                ->validate()
                    ->ifTrue(function ($v) { return 'flowdock' === $v['type'] && empty($v['from_email']); })
                    ->thenInvalid('The from_email has to be specified to use a FlowdockHandler')
                ->end()
                ->validate()
                    ->ifTrue(function ($v) { return 'flowdock' === $v['type'] && empty($v['source']); })
                    ->thenInvalid('The source has to be specified to use a FlowdockHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::FLOWDOCK;
    }
}
