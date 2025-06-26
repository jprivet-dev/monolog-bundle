<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class SlackHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('channel')->defaultNull()->info('Channel name (with starting #).')->end() // slack
                ->scalarNode('bot_name')->defaultValue('Monolog')->end() // slack
                ->scalarNode('use_attachment')->defaultTrue()->end() // slack
                ->scalarNode('use_short_attachment')->defaultFalse()->end() // slack
                ->scalarNode('include_extra')->defaultFalse()->end() // slack
                ->scalarNode('icon_emoji')->defaultNull()->end() // slack
                ->scalarNode('token')->info('Slack api token')->end() // slack
                ->scalarNode('timeout')->end() // slack
                ->scalarNode('connection_timeout')->end() // slack
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::SLACK;
    }
}
