<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class RotatingfileHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->scalarNode('path')->defaultValue('%kernel.logs_dir%/%kernel.environment%.log')->end() // rotating
                ->scalarNode('max_files')->defaultValue(0)->info('Files to keep, defaults to zero (infinite).')->end() // rotating
                ->scalarNode('file_permission')  // rotating
                    ->defaultNull()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) {
                            if ('0' === substr($v, 0, 1)) {
                                return octdec($v);
                            }

                            return (int) $v;
                        })
                    ->end()
                ->end()
                ->booleanNode('use_locking')->defaultFalse()->end() // rotating
                ->scalarNode('filename_format')->defaultValue('{filename}-{date}')->end() // rotating
                ->scalarNode('date_format')->defaultValue('Y-m-d')->end() // rotating
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::ROTATING_FILE;
    }
}
