<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class SamplingHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->scalarNode('handler')->info('The wrapped handler\'s name.')->end() // sampling
                ->integerNode('factor')->defaultValue(1)->min(1)->end() // sampling
            ->end()
        ;

        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'sampling' === $v['type'] && empty($v['handler']); })
                    ->thenInvalid('The handler has to be specified to use a SamplingHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::SAMPLING;
    }
}
