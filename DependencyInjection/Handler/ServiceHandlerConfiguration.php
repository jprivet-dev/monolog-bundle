<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class ServiceHandlerConfiguration extends AbstractHandlerConfiguration
{
    static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->scalarNode('id')->end() // service
            ->end()
        ;

        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'service' === $v['type'] && !empty($v['formatter']); })
                    ->thenInvalid('Service handlers can not have a formatter configured in the bundle, you must reconfigure the service itself instead')
                ->end()
                ->validate()
                    ->ifTrue(function ($v) { return 'service' === $v['type'] && !isset($v['id']); })
                    ->thenInvalid('The id has to be specified to use a service as handler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::SERVICE;
    }
}
