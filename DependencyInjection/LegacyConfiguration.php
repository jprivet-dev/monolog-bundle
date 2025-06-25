<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection;

use Monolog\Logger;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ChannelsHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\CubeHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ElasticsearchHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FilterHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FingerscrossedHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FlowdockHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\GelfHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\HipchatHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\InsightopsHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\LogentriesHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\LogglyHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\MongoHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\NativeMailerHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\PredisHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\PushoverHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\RavenHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\RedisHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\RollbarHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ServerlogHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ServiceHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SlackbotHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SlackHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SlackwebhookHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SocketHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SwiftMailerHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SymfonyMailerHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SyslogudpHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\TelegramHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\VerbosityLevelHandlerConfiguration;
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
                ->scalarNode('id')->end() // service & rollbar
                ->scalarNode('priority')->defaultValue(0)->end()
                ->scalarNode('level')->defaultValue('DEBUG')->end()
                ->booleanNode('bubble')->defaultTrue()->end()
                ->scalarNode('app_name')->defaultNull()->end()
                ->booleanNode('fill_extra_context')->defaultFalse()->end() // sentry
                ->booleanNode('include_stacktraces')->defaultFalse()->end()
                ->arrayNode('process_psr_3_messages')
                    ->addDefaultsIfNotSet()
                    ->beforeNormalization()
                        ->ifTrue(static function ($v) { return !\is_array($v); })
                        ->then(static function ($v) { return ['enabled' => $v]; })
                    ->end()
                    ->children()
                        ->booleanNode('enabled')->defaultNull()->end()
                        ->scalarNode('date_format')->end()
                        ->booleanNode('remove_used_context_fields')->end()
                    ->end()
                ->end()
                ->scalarNode('path')->defaultValue('%kernel.logs_dir%/%kernel.environment%.log')->end() // stream and rotating
                ->scalarNode('file_permission')  // stream and rotating
                    ->defaultNull()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) {
                            if ('0' === substr($v, 0, 1)) {
                                return octdec($v);
                            }

                            return (int) $v;
                        })
                    ->end()
                ->end()
                ->booleanNode('use_locking')->defaultFalse()->end() // stream and rotating
                ->scalarNode('filename_format')->defaultValue('{filename}-{date}')->end() // rotating
                ->scalarNode('date_format')->defaultValue('Y-m-d')->end() // rotating
                ->scalarNode('ident')->defaultFalse()->end() // syslog and syslogudp
                ->scalarNode('logopts')->defaultValue(\LOG_PID)->end() // syslog
                ->scalarNode('facility')->defaultValue('user')->end() // syslog
                ->scalarNode('max_files')->defaultValue(0)->end() // rotating
                ->scalarNode('action_level')->defaultValue('WARNING')->end() // fingers_crossed
                ->scalarNode('activation_strategy')->defaultNull()->end() // fingers_crossed
                ->booleanNode('stop_buffering')->defaultTrue()->end()// fingers_crossed
                ->scalarNode('passthru_level')->defaultNull()->end() // fingers_crossed
                ->arrayNode('excluded_404s') // fingers_crossed
                    ->canBeUnset()
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('excluded_http_codes') // fingers_crossed
                    ->canBeUnset()
                    ->beforeNormalization()
                        ->always(function ($values) {
                            return array_map(function ($value) {
                                /*
                                 * Allows YAML:
                                 *   excluded_http_codes: [403, 404, { 400: ['^/foo', '^/bar'] }]
                                 *
                                 * and XML:
                                 *   <monolog:excluded-http-code code="403">
                                 *     <monolog:url>^/foo</monolog:url>
                                 *     <monolog:url>^/bar</monolog:url>
                                 *   </monolog:excluded-http-code>
                                 *   <monolog:excluded-http-code code="404" />
                                 */

                                if (\is_array($value)) {
                                    return isset($value['code']) ? $value : ['code' => key($value), 'urls' => current($value)];
                                }

                                return ['code' => $value, 'urls' => []];
                            }, $values);
                        })
                    ->end()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('code')->end()
                            ->arrayNode('urls')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
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
                 // console
                ->variableNode('console_formater_options')
                    ->setDeprecated('symfony/monolog-bundle', 3.7, '"%path%.%node%" is deprecated, use "%path%.console_formatter_options" instead.')
                    ->validate()
                        ->ifTrue(function ($v) {
                            return !\is_array($v);
                        })
                        ->thenInvalid('The console_formater_options must be an array.')
                    ->end()
                ->end()
                ->variableNode('console_formatter_options')
                    ->defaultValue([])
                    ->validate()
                        ->ifTrue(static function ($v) { return !\is_array($v); })
                        ->thenInvalid('The console_formatter_options must be an array.')
                    ->end()
                ->end()
                ->scalarNode('formatter')->end()
                ->booleanNode('nested')->defaultFalse()->end()
            ->end();

        GelfHandlerConfiguration::addOptions($handlerNode, true);
        MongoHandlerConfiguration::addOptions($handlerNode, true);
        ElasticsearchHandlerConfiguration::addOptions($handlerNode, true);
        RedisHandlerConfiguration::addOptions($handlerNode, true);
        PredisHandlerConfiguration::addOptions($handlerNode, true);
        SwiftMailerHandlerConfiguration::addOptions($handlerNode, true);
        NativeMailerHandlerConfiguration::addOptions($handlerNode, true);
        SymfonyMailerHandlerConfiguration::addOptions($handlerNode, true);
        VerbosityLevelHandlerConfiguration::addOptions($handlerNode, true);
        ChannelsHandlerConfiguration::addOptions($handlerNode, true);

        $handlerNode
            ->beforeNormalization()
                ->always(static function ($v) {
                    if (empty($v['console_formatter_options']) && !empty($v['console_formater_options'])) {
                        $v['console_formatter_options'] = $v['console_formater_options'];
                    }

                    return $v;
                })
            ->end()
            ->validate()
                ->always(static function ($v) {
                    unset($v['console_formater_options']);

                    return $v;
                })
            ->end()
        ;

        ServiceHandlerConfiguration::addOptions($handlerNode, true);
        FingerscrossedHandlerConfiguration::addOptions($handlerNode, true);
        FilterHandlerConfiguration::addOptions($handlerNode, true);
        RollbarHandlerConfiguration::addOptions($handlerNode, true);
        TelegramHandlerConfiguration::addOptions($handlerNode, true);
        ServiceHandlerConfiguration::addOptions($handlerNode, true);
        SyslogudpHandlerConfiguration::addOptions($handlerNode, true);
        SocketHandlerConfiguration::addOptions($handlerNode, true);
        PushoverHandlerConfiguration::addOptions($handlerNode, true);
        RavenHandlerConfiguration::addOptions($handlerNode, true);
        HipchatHandlerConfiguration::addOptions($handlerNode, true);
        SlackHandlerConfiguration::addOptions($handlerNode, true);
        SlackwebhookHandlerConfiguration::addOptions($handlerNode, true);
        SlackbotHandlerConfiguration::addOptions($handlerNode, true);
        CubeHandlerConfiguration::addOptions($handlerNode, true);
        LogglyHandlerConfiguration::addOptions($handlerNode, true);
        LogentriesHandlerConfiguration::addOptions($handlerNode, true);
        InsightopsHandlerConfiguration::addOptions($handlerNode, true);
        FlowdockHandlerConfiguration::addOptions($handlerNode, true);
        ServerlogHandlerConfiguration::addOptions($handlerNode, true);
    }
}
