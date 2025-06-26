<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class SamplingHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('handler')->info('The wrapped handler\'s name.')->end() // sampling
                ->integerNode('factor')->defaultValue(1)->min(1)->end() // sampling
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::SAMPLING;
    }
}
