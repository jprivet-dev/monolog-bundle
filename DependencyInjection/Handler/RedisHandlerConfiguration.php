<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class RedisHandlerConfiguration extends AbstractHandlerConfiguration
{
    static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void {
        $node
            ->children()
                ->arrayNode('redis')
                    ->canBeUnset()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return ['id' => $v]; })
                    ->end()
                    ->children()
                        ->scalarNode('id')->end()
                        ->scalarNode('host')->end()
                        ->scalarNode('password')->defaultNull()->end()
                        ->scalarNode('port')->defaultValue(6379)->end()
                        ->scalarNode('database')->defaultValue(0)->end()
                        ->scalarNode('key_name')->defaultValue('monolog_redis')->end()
                    ->end()
                    ->validate()
                        ->ifTrue(function ($v) {
                            return !isset($v['id']) && !isset($v['host']);
                        })
                        ->thenInvalid('What must be set is either the host or the service id of the Redis client.')
                    ->end()
                ->end()
            ->end()
        ;

        if($legacy) {
              $node
                ->validate()
                    ->ifTrue(function ($v) { return 'redis' === $v['type'] && empty($v['redis']); })
                    ->thenInvalid('The host has to be specified to use a RedisLogHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::REDIS;
    }
}
