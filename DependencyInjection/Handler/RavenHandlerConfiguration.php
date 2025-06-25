<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class RavenHandlerConfiguration extends AbstractHandlerConfiguration
{
    static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'sentry' === $v['type'] && !\array_key_exists('dsn', $v) && null === $v['hub_id'] && null === $v['client_id']; })
                    ->thenInvalid('The DSN has to be specified to use Sentry\'s handler')
                ->end()
                ->validate()
                    ->ifTrue(function ($v) { return 'sentry' === $v['type'] && null !== $v['hub_id'] && null !== $v['client_id']; })
                    ->thenInvalid('You can not use both a hub_id and a client_id in a Sentry handler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::RAVEN;
    }
}
