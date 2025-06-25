<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class GelfHandlerConfiguration extends AbstractHandlerConfiguration
{
    static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void {
        $node
            ->children()
                ->arrayNode('publisher')
                    ->canBeUnset()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return ['id' => $v]; })
                    ->end()
                    ->children()
                        ->scalarNode('id')->end()
                        ->scalarNode('hostname')->end()
                        ->scalarNode('port')->defaultValue(12201)->end()
                        ->scalarNode('chunk_size')->defaultValue(1420)->end()
                    ->end()
                    ->validate()
                        ->ifTrue(function ($v) {
                            return !isset($v['id']) && !isset($v['hostname']);
                        })
                        ->thenInvalid('What must be set is either the hostname or the id.')
                    ->end()
                ->end()
            ->end()
        ;

        if($legacy) {
              $node
                ->validate()
                    ->ifTrue(function ($v) { return 'gelf' === $v['type'] && !isset($v['publisher']); })
                    ->thenInvalid('The publisher has to be specified to use a GelfHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::GELF;
    }
}
