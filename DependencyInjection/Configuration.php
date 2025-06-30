<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MonologBundle\DependencyInjection;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\HandlerConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class contains the configuration information for the bundle.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @author Christophe Coevoet <stof@notk.org>
 *
 * @final since 3.9.0
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * This method defines two main configuration structures for handlers:
     * 1. A legacy, flat structure for backward compatibility (using a 'type' scalar node).
     * 2. A new, type-prefixed structure (e.g., 'type_stream') for better clarity and explicit handler configuration.
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('monolog');
        $rootNode = $treeBuilder->getRootNode();

        $handlers = $rootNode
            ->fixXmlConfig('channel')
            ->fixXmlConfig('handler')
            ->children()
                ->scalarNode('use_microseconds')->defaultTrue()->end()
                ->arrayNode('channels')
                    ->canBeUnset()
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('handlers');

        $handlers
            ->canBeUnset()
            ->useAttributeAsKey('name')
            ->validate()
                ->ifTrue(function ($v) { return isset($v['debug']); })
                ->thenInvalid('The "debug" name cannot be used as it is reserved for the handler of the profiler')
            ->end()
            ->example([
                'syslog' => [
                    'type' => 'stream',
                    'path' => '/var/log/symfony.log',
                    'level' => 'ERROR',
                    'bubble' => 'false',
                    'formatter' => 'my_formatter',
                ],
                'main' => [
                    'type' => 'fingers_crossed',
                    'action_level' => 'WARNING',
                    'buffer_size' => 30,
                    'handler' => 'custom',
                ],
                'custom' => [
                    'type' => 'service',
                    'id' => 'my_handler',
                ],
            ]);

        $handlerNode = $handlers
            ->prototype('array')
                ->fixXmlConfig('member')
                ->fixXmlConfig('excluded_404')
                ->fixXmlConfig('excluded_http_code')
                ->fixXmlConfig('tag')
                ->fixXmlConfig('accepted_level')
                ->fixXmlConfig('header')
                ->canBeUnset()
                ->validate()
                    ->ifTrue(function ($v) {
                        return $this->hasMultipleHandlerTypesConfigured($v);
                    })
                    ->then(function ($v) {
                        throw new InvalidConfigurationException($this->getMultipleHandlerTypesErrorMessage($v));
                    })
                ->end()
        ;

        $this->addLegacyHandlerOptions($handlerNode);
        $this->addNewTypePrefixedHandlerOptions($handlerNode);

        return $treeBuilder;
    }

    /**
     * Checks if a handler configuration has multiple handler types defined.
     */
    private function hasMultipleHandlerTypesConfigured(array $handlerConfig): bool
    {
        $configuredTypePrefixes = [];
        foreach (HandlerType::cases() as $type) {
            if (isset($handlerConfig[$type->withTypePrefix()])) {
                $configuredTypePrefixes[] = $type->withTypePrefix();
            }
        }

        // 1. more than one type_xxx is configured (conflict between new syntaxes)
        // 2. a type_xxx IS configured AND the legacy 'type' key is ALSO configured
        return (count($configuredTypePrefixes) > 1)
            || (count($configuredTypePrefixes) > 0 && isset($handlerConfig['type']) && null !== $handlerConfig['type']);
    }

    /**
     * Generates a detailed error message when multiple handler types are configured.
     */
    private function getMultipleHandlerTypesErrorMessage(array $handlerConfig): string
    {
        $configuredTypePrefixes = [];
        foreach (HandlerType::cases() as $type) {
            if (isset($handlerConfig[$type->withTypePrefix()])) {
                $configuredTypePrefixes[] = $type->withTypePrefix();
            }
        }

        $message = 'A handler can only have one type defined. You have configured multiple types: ';
        $message .= implode(', ', $configuredTypePrefixes);
        if (isset($handlerConfig['type']) && null !== $handlerConfig['type']) {
            $message .= ' and the legacy "type: '.$handlerConfig['type'].'" key.';
        }
        $message .= ' Please choose only one handler type (either a "type_xxx" prefixed key or the legacy "type" key).';

        return $message;
    }

    /**
     * Defines options for handlers using the legacy flat structure.
     * This allows configuring handlers with a 'type' scalar node directly alongside other options.
     * E.g., type: stream, path: /path/to/log
     */
    protected function addLegacyHandlerOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->scalarNode('type')
                    ->cannotBeEmpty()
                    ->treatNullLike('null')
                    ->beforeNormalization()
                        ->always()
                        ->then(function ($v) { return strtolower($v); })
                    ->end()
                ->end()
                // Keep console_formater_options with console_formatter_options in legacy version.
                ->variableNode('console_formater_options')
                    ->setDeprecated('symfony/monolog-bundle', 3.7, '"%path%.%node%" is deprecated, use "%path%.console_formatter_options" instead.')
                    ->validate()
                        ->ifTrue(function ($v) {
                            return !\is_array($v);
                        })
                        ->thenInvalid('The console_formater_options must be an array.')
                    ->end()
                ->end()
            ->end();

        $this->addCommonOptions($handlerNode);

        // Add type-specific options directly to the handler prototype for legacy syntax.
        foreach (HandlerType::cases() as $type) {
            $this->getHandlerConfiguration($type)->addOptions($handlerNode);
        }

        $this->addCommonValidations($handlerNode);
    }

    /**
     * Defines options for handlers using the new type-prefixed structure.
     * This allows configuring handlers with a nested 'type_xxx' key where options are grouped.
     * E.g., type_stream: { path: /pa
     * th/to/log }
     */
    private function addNewTypePrefixedHandlerOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void {
        foreach (HandlerType::cases() as $type) {
            $typeNode = $handlerNode
                ->children()
                    ->arrayNode($type->withTypePrefix())
                        ->canBeUnset()
                        ->info($type->getDescription())
                        ->children()
                            ->scalarNode('type')
                                ->defaultValue($type->value)
                                ->cannotBeOverwritten()
                                ->info('Automatically set by the bundle for internal use and backward compatibility. Do not define this key manually.')
                            ->end()
                        ->end()
            ;

            $this->addCommonOptions($typeNode);
            $this->getHandlerConfiguration($type)->addOptions($typeNode);
            $this->addCommonValidations($typeNode);
        }
    }

    /**
     * Adds common Monolog handler options to the given node.
     * These options apply to most Monolog handlers regardless of their specific type.
     */
    private function addCommonOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->scalarNode('priority')->defaultValue(0)->info('Defines the processing order; handlers with a higher priority value are executed first.')->end()
                ->scalarNode('level')->defaultValue('DEBUG')->info('Level name or int value, defaults to DEBUG.')->end()
                ->booleanNode('bubble')->defaultTrue()->info('When true, messages are passed to the next handler in the stack; when false, the chain ends here.')->end()
                ->booleanNode('include_stacktraces')->defaultFalse()->info('When true, a full stack trace is included in the log record, especially for errors and exceptions.')->end()
                ->booleanNode('nested')->defaultFalse()->info('When true, this handler is part of a nested handler configuration (e.g., as the primary handler of a FingersCrossedHandler).')->end()
                ->scalarNode('formatter')->info('The formatter used to format the log records. Can be a service ID or a formatter configuration.')->end()
            ->end()
        ;
    }

    /**
     * Adds common validation rules and normalization to the given handler node.
     *
     * This method ensures consistent validation and backward compatibility across
     * both the legacy (flat) and new (type-prefixed) handler configuration structures.
     * It handles:
     * - Deprecated options, ensuring their values are correctly migrated (e.g., 'console_formater_options').
     * - Incompatible option combinations (e.g., 'service' handler with a 'formatter').
     * - Missing mandatory options for specific handler types (e.g., 'handler' for 'fingers_crossed').
     */
    private function addCommonValidations(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
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
            ->validate()
                ->ifTrue(function ($v) { return 'service' === $v['type'] && !empty($v['formatter']); })
                ->thenInvalid('Service handlers can not have a formatter configured in the bundle, you must reconfigure the service itself instead')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return ('fingers_crossed' === $v['type'] || 'buffer' === $v['type'] || 'filter' === $v['type'] || 'sampling' === $v['type']) && empty($v['handler']); })
                ->thenInvalid('The handler has to be specified to use a FingersCrossedHandler or BufferHandler or FilterHandler or SamplingHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'fingers_crossed' === $v['type'] && !empty($v['excluded_404s']) && !empty($v['activation_strategy']); })
                ->thenInvalid('You can not use excluded_404s together with a custom activation_strategy in a FingersCrossedHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'fingers_crossed' === $v['type'] && !empty($v['excluded_http_codes']) && !empty($v['activation_strategy']); })
                ->thenInvalid('You can not use excluded_http_codes together with a custom activation_strategy in a FingersCrossedHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'fingers_crossed' === $v['type'] && !empty($v['excluded_http_codes']) && !empty($v['excluded_404s']); })
                ->thenInvalid('You can not use excluded_http_codes together with excluded_404s in a FingersCrossedHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'fingers_crossed' !== $v['type'] && (!empty($v['excluded_http_codes']) || !empty($v['excluded_404s'])); })
                ->thenInvalid('You can only use excluded_http_codes/excluded_404s with a FingersCrossedHandler definition')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'filter' === $v['type'] && 'DEBUG' !== $v['min_level'] && !empty($v['accepted_levels']); })
                ->thenInvalid('You can not use min_level together with accepted_levels in a FilterHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'filter' === $v['type'] && 'EMERGENCY' !== $v['max_level'] && !empty($v['accepted_levels']); })
                ->thenInvalid('You can not use max_level together with accepted_levels in a FilterHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'rollbar' === $v['type'] && !empty($v['id']) && !empty($v['token']); })
                ->thenInvalid('You can not use both an id and a token in a RollbarHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'rollbar' === $v['type'] && empty($v['id']) && empty($v['token']); })
                ->thenInvalid('The id or the token has to be specified to use a RollbarHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'telegram' === $v['type'] && (empty($v['token']) || empty($v['channel'])); })
                ->thenInvalid('The token and channel have to be specified to use a TelegramBotHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'service' === $v['type'] && !isset($v['id']); })
                ->thenInvalid('The id has to be specified to use a service as handler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'syslogudp' === $v['type'] && !isset($v['host']); })
                ->thenInvalid('The host has to be specified to use a syslogudp as handler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'socket' === $v['type'] && !isset($v['connection_string']); })
                ->thenInvalid('The connection_string has to be specified to use a SocketHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'pushover' === $v['type'] && (empty($v['token']) || empty($v['user'])); })
                ->thenInvalid('The token and user have to be specified to use a PushoverHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'raven' === $v['type'] && !\array_key_exists('dsn', $v) && null === $v['client_id']; })
                ->thenInvalid('The DSN has to be specified to use a RavenHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'sentry' === $v['type'] && !\array_key_exists('dsn', $v) && null === $v['hub_id'] && null === $v['client_id']; })
                ->thenInvalid('The DSN has to be specified to use Sentry\'s handler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'sentry' === $v['type'] && null !== $v['hub_id'] && null !== $v['client_id']; })
                ->thenInvalid('You can not use both a hub_id and a client_id in a Sentry handler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'hipchat' === $v['type'] && (empty($v['token']) || empty($v['room'])); })
                ->thenInvalid('The token and room have to be specified to use a HipChatHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'hipchat' === $v['type'] && !\in_array($v['message_format'], ['text', 'html']); })
                ->thenInvalid('The message_format has to be "text" or "html" in a HipChatHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'hipchat' === $v['type'] && null !== $v['api_version'] && !\in_array($v['api_version'], ['v1', 'v2'], true); })
                ->thenInvalid('The api_version has to be "v1" or "v2" in a HipChatHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'slack' === $v['type'] && (empty($v['token']) || empty($v['channel'])); })
                ->thenInvalid('The token and channel have to be specified to use a SlackHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'slackwebhook' === $v['type'] && (empty($v['webhook_url'])); })
                ->thenInvalid('The webhook_url have to be specified to use a SlackWebhookHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'slackbot' === $v['type'] && (empty($v['team']) || empty($v['token']) || empty($v['channel'])); })
                ->thenInvalid('The team, token and channel have to be specified to use a SlackbotHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'cube' === $v['type'] && empty($v['url']); })
                ->thenInvalid('The url has to be specified to use a CubeHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'amqp' === $v['type'] && empty($v['exchange']); })
                ->thenInvalid('The exchange has to be specified to use a AmqpHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'loggly' === $v['type'] && empty($v['token']); })
                ->thenInvalid('The token has to be specified to use a LogglyHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'loggly' === $v['type'] && !empty($v['tags']); })
                ->then(function ($v) {
                    $invalidTags = preg_grep('/^[a-z0-9][a-z0-9\.\-_]*$/i', $v['tags'], \PREG_GREP_INVERT);
                    if (!empty($invalidTags)) {
                        throw new InvalidConfigurationException(\sprintf('The following Loggly tags are invalid: %s.', implode(', ', $invalidTags)));
                    }

                    return $v;
                })
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'logentries' === $v['type'] && empty($v['token']); })
                ->thenInvalid('The token has to be specified to use a LogEntriesHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'insightops' === $v['type'] && empty($v['token']); })
                ->thenInvalid('The token has to be specified to use a InsightOpsHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'flowdock' === $v['type'] && empty($v['token']); })
                ->thenInvalid('The token has to be specified to use a FlowdockHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'flowdock' === $v['type'] && empty($v['from_email']); })
                ->thenInvalid('The from_email has to be specified to use a FlowdockHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'flowdock' === $v['type'] && empty($v['source']); })
                ->thenInvalid('The source has to be specified to use a FlowdockHandler')
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'server_log' === $v['type'] && empty($v['host']); })
                ->thenInvalid('The host has to be specified to use a ServerLogHandler')
            ->end()
        ;
    }

    /**
     * Retrieves the handler configuration class for a given HandlerType.
     */
    private function getHandlerConfiguration(HandlerType $type): HandlerConfigurationInterface
    {
        $class = $type->getHandlerConfigurationClass();

        if (!$class) {
            throw new \RuntimeException(\sprintf('The handler configuration "%s" is not registered.', $type->value));
        }

        if (!class_exists($class)) {
            throw new \RuntimeException(\sprintf('The class "%s" does not exist.', $class));
        }

        $handlerConfiguration = new $class();

        if (!$handlerConfiguration instanceof HandlerConfigurationInterface) {
            throw new \RuntimeException(\sprintf('Expected class of type "%s", "%s" given', HandlerConfigurationInterface::class, $class));
        }

        return $handlerConfiguration;
    }
}
