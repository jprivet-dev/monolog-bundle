<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class SlackwebhookHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->scalarNode('channel')->defaultNull()->end() // slackwebhook
                ->scalarNode('bot_name')->defaultValue('Monolog')->end() // slackwebhook
                ->scalarNode('use_attachment')->defaultTrue()->end() // slackwebhook
                ->scalarNode('use_short_attachment')->defaultFalse()->end() // slackwebhook
                ->scalarNode('include_extra')->defaultFalse()->end() // slackwebhook
                ->scalarNode('icon_emoji')->defaultNull()->end() // slackwebhook
                ->scalarNode('webhook_url')->end() // slackwebhook
            ->end()
        ;
    }


    public function getType(): HandlerType
    {
        return HandlerType::SLACKWEBHOOK;
    }
}
