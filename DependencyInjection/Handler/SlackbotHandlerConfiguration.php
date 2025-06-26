<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class SlackbotHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('channel')->defaultNull()->end() // slackbot
                ->scalarNode('team')->end() // slackbot
                ->scalarNode('token')->end() // slackbot
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::SLACKBOT;
    }
}
