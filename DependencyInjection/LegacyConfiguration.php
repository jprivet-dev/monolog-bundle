<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection;

use Monolog\Logger;
use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\AbstractHandlerConfiguration;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class LegacyConfiguration implements AppendConfigurationInterface
{
    public function __invoke(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->scalarNode('type')
                    ->isRequired()
                    ->treatNullLike('null')
                    ->beforeNormalization()
                        ->always()
                        ->then(function ($v) { return strtolower($v); })
                    ->end()
                ->end()
                ->arrayNode('accepted_levels') // filter
                    ->canBeUnset()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('min_level')->defaultValue('DEBUG')->end() // filter
                ->scalarNode('max_level')->defaultValue('EMERGENCY')->end() // filter
                ->scalarNode('buffer_size')->defaultValue(0)->end() // fingers_crossed and buffer
                ->booleanNode('flush_on_overflow')->defaultFalse()->end() // buffer
                ->scalarNode('handler')->end() // fingers_crossed and buffer
                ->scalarNode('url')->end() // cube
                ->scalarNode('exchange')->end() // amqp
                ->scalarNode('exchange_name')->defaultValue('log')->end() // amqp
                ->scalarNode('room')->end() // hipchat
                ->scalarNode('message_format')->defaultValue('text')->end() // hipchat
                ->scalarNode('api_version')->defaultNull()->end() // hipchat
                ->scalarNode('channel')->defaultNull()->end() // slack & slackwebhook & slackbot & telegram
                ->scalarNode('bot_name')->defaultValue('Monolog')->end() // slack & slackwebhook
                ->scalarNode('use_attachment')->defaultTrue()->end() // slack & slackwebhook
                ->scalarNode('use_short_attachment')->defaultFalse()->end() // slack & slackwebhook
                ->scalarNode('include_extra')->defaultFalse()->end() // slack & slackwebhook
                ->scalarNode('icon_emoji')->defaultNull()->end() // slack & slackwebhook
                ->scalarNode('webhook_url')->end() // slackwebhook
                ->scalarNode('team')->end() // slackbot
                ->scalarNode('notify')->defaultFalse()->end() // hipchat
                ->scalarNode('nickname')->defaultValue('Monolog')->end() // hipchat
                ->scalarNode('token')->end() // pushover & hipchat & loggly & logentries & flowdock & rollbar & slack & slackbot & insightops & telegram
                ->scalarNode('region')->end() // insightops
                ->scalarNode('source')->end() // flowdock
                ->booleanNode('use_ssl')->defaultTrue()->end() // logentries & hipchat & insightops
                ->variableNode('user') // pushover
                    ->validate()
                        ->ifTrue(function ($v) {
                            return !\is_string($v) && !\is_array($v);
                        })
                        ->thenInvalid('User must be a string or an array.')
                    ->end()
                ->end()
                ->scalarNode('title')->defaultNull()->end() // pushover
                ->scalarNode('host')->defaultNull()->end() // syslogudp & hipchat
                ->scalarNode('port')->defaultValue(514)->end() // syslogudp
                ->arrayNode('config')
                    ->canBeUnset()
                    ->prototype('scalar')->end()
                ->end() // rollbar
                ->arrayNode('members') // group, whatfailuregroup, fallbackgroup
                    ->canBeUnset()
                    ->performNoDeepMerging()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('connection_string')->end() // socket_handler
                ->scalarNode('timeout')->end() // socket_handler, logentries, pushover, hipchat & slack
                ->scalarNode('time')->defaultValue(60)->end() // deduplication
                ->scalarNode('deduplication_level')->defaultValue(Logger::ERROR)->end() // deduplication
                ->scalarNode('store')->defaultNull()->end() // deduplication
                ->scalarNode('connection_timeout')->end() // socket_handler, logentries, pushover, hipchat & slack
                ->booleanNode('persistent')->end() // socket_handler
                ->scalarNode('dsn')->end() // raven_handler, sentry_handler
                ->scalarNode('hub_id')->defaultNull()->end() // sentry_handler
                ->scalarNode('client_id')->defaultNull()->end() // raven_handler, sentry_handler
                ->scalarNode('auto_log_stacks')->defaultFalse()->end() // raven_handler
                ->scalarNode('release')->defaultNull()->end() // raven_handler, sentry_handler
                ->scalarNode('environment')->defaultNull()->end() // raven_handler, sentry_handler
                ->scalarNode('message_type')->defaultValue(0)->end() // error_log
                ->scalarNode('parse_mode')->defaultNull()->end() // telegram
                ->booleanNode('disable_webpage_preview')->defaultNull()->end() // telegram
                ->booleanNode('disable_notification')->defaultNull()->end() // telegram
                ->booleanNode('split_long_messages')->defaultFalse()->end() // telegram
                ->booleanNode('delay_between_messages')->defaultFalse()->end() // telegram
                ->integerNode('factor')->defaultValue(1)->min(1)->end() // sampling
                ->arrayNode('tags') // loggly
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return explode(',', $v); })
                    ->end()
                    ->beforeNormalization()
                        ->ifArray()
                        ->then(function ($v) { return array_filter(array_map('trim', $v)); })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        foreach (HandlerType::cases() as $type) {
            $this->addOptionsByClass($this->getHandlerConfigurationClassByType($type), $handlerNode, true);
        }
    }

    private function addOptionsByClass(string $class, NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode, bool $legacy = false): void
    {
        if (!class_exists($class)) {
            throw new \RuntimeException(\sprintf('The class "%s" does not exist.', $class));
        }

        if (!is_subclass_of($class, AbstractHandlerConfiguration::class)) {
            throw new \RuntimeException(\sprintf('Expected class of type "%s", "%s" given', AbstractHandlerConfiguration::class, $class));
        }

        $class::addCommonOptions($handlerNode, $legacy);
        $class::addOptions($handlerNode, $legacy);
    }

    private function getHandlerConfigurationClassByType(HandlerType $type): string
    {
        $class = $type->getHandlerConfigurationClass();

        if (!$class) {
            throw new \RuntimeException(\sprintf('The handler configuration "%s" is not registered.', $type->value));
        }

        return $class;
    }
}
