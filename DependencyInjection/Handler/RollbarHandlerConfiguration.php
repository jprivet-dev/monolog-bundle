<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class RollbarHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('id')->info('RollbarNotifier service (mandatory if token is not provided).')->end() // rollbar
                ->scalarNode('token')->info('Rollbar api token (skip if you provide a RollbarNotifier service id).')->end() // rollbar
                ->arrayNode('config') // rollbar
                    ->canBeUnset()
                    ->info('Config values from https://github.com/rollbar/rollbar-php#configuration-reference.')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::ROLLBAR;
    }
}
