<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class WhatfailuregroupHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->arrayNode('members') // whatfailuregroup
                    ->canBeUnset()
                    ->performNoDeepMerging()
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::WHATFAILUREGROUP;
    }
}
