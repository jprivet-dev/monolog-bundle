<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class SentryHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node): void
    {
        $node
            ->children()
                ->booleanNode('fill_extra_context')->defaultFalse()->end() // sentry
                ->scalarNode('dsn')->end() // sentry
                ->scalarNode('hub_id')->defaultNull()->end() // sentry
                ->scalarNode('client_id')->defaultNull()->end() // sentry
                ->scalarNode('release')->defaultNull()->end() // sentry
                ->scalarNode('environment')->defaultNull()->end() // sentry
            ->end();
    }

    public function getType(): HandlerType
    {
        return HandlerType::SENTRY;
    }
}
