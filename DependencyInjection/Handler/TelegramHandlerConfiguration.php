<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class TelegramHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->scalarNode('channel')->defaultNull()->info('Telegram channel name.')->end() // slack
                ->scalarNode('token')->info('Telegram bot access token provided by BotFather.')->end() // slack
                ->scalarNode('parse_mode')->defaultNull()->info('Optional the kind of formatting that is used for the message.')->end() // slack
                ->booleanNode('disable_webpage_preview')->defaultNull()->info('Disables link previews for links in the message.')->end() // slack
                ->booleanNode('disable_notification')->defaultNull()->info('Sends the message silently. Users will receive a notification with no sound.')->end() // slack
                ->booleanNode('split_long_messages')->defaultFalse()->info('Split messages longer than 4096 bytes into multiple messages.')->end() // slack
                ->booleanNode('delay_between_messages')->defaultFalse()->info('Adds a 1sec delay/sleep between sending split messages.')->end() // slack
            ->end()
        ;

        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'telegram' === $v['type'] && (empty($v['token']) || empty($v['channel'])); })
                    ->thenInvalid('The token and channel have to be specified to use a TelegramBotHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::TELEGRAM;
    }
}
