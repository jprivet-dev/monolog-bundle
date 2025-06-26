<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class PredisHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->arrayNode('predis')
                    ->canBeUnset()
                    ->beforeNormalization()
                    ->ifString()
                    ->then(function ($v) { return ['id' => $v]; })
                    ->end()
                    ->children()
                        ->scalarNode('id')->end()
                        ->scalarNode('host')->end()
                    ->end()
                    ->validate()
                    ->ifTrue(function ($v) {
                        return !isset($v['id']) && !isset($v['host']);
                    })
                    ->thenInvalid('What must be set is either the host or the service id of the Predis client.')
                    ->end()
                ->end()
            ->end()
        ;

        if($legacy) {
              $node
                ->validate()
                    ->ifTrue(function ($v) { return 'predis' === $v['type'] && empty($v['redis']); })
                    ->thenInvalid('The host has to be specified to use a RedisLogHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::PREDIS;
    }
}
