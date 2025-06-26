<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Monolog\Logger;
use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class DeduplicationHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('handler')->info('The wrapped handler\'s name.')->end() // deduplication
                ->scalarNode('time')->defaultValue(60)->end() // deduplication
                ->scalarNode('deduplication_level')->defaultValue(Logger::ERROR)->end() // deduplication
                ->scalarNode('store')->defaultNull()->end() // deduplication
           ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::DEDUPLICATION;
    }
}
