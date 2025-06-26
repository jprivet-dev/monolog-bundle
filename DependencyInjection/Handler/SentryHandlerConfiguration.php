<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class SentryHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
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

        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'pushover' === $v['type'] && (empty($v['token']) || empty($v['user'])); })
                    ->thenInvalid('The token and user have to be specified to use a PushoverHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::SENTRY;
    }
}
