<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class MongoHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->arrayNode('mongo')
                    ->canBeUnset()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return ['id' => $v]; })
                    ->end()
                    ->children()
                        ->scalarNode('id')->end()
                        ->scalarNode('host')->info('Database host name, optional if id is given.')->end()
                        ->scalarNode('port')->defaultValue(27017)->end()
                        ->scalarNode('user')->info('Database user name')->end()
                        ->scalarNode('pass')->info('Mandatory only if user is present.')->end()
                        ->scalarNode('database')->defaultValue('monolog')->end()
                        ->scalarNode('collection')->defaultValue('logs')->end()
                    ->end()
                    ->validate()
                        ->ifTrue(function ($v) {
                            return !isset($v['id']) && !isset($v['host']);
                        })
                        ->thenInvalid('What must be set is either the host or the id.')
                    ->end()
                    ->validate()
                        ->ifTrue(function ($v) {
                            return isset($v['user']) && !isset($v['pass']);
                        })
                        ->thenInvalid('If you set user, you must provide a password.')
                    ->end()
                ->end()
            ->end()
        ;

        if($legacy) {
              $node
                ->validate()
                    ->ifTrue(function ($v) { return 'mongo' === $v['type'] && !isset($v['mongo']); })
                    ->thenInvalid('The mongo configuration has to be specified to use a MongoHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::MONGO;
    }
}
