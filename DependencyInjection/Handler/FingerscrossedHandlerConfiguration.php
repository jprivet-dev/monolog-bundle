<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class FingerscrossedHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->scalarNode('handler')->info('The wrapped handler\'s name.')->end() // fingers_crossed
                ->scalarNode('action_level')->defaultValue('WARNING')->info('Minimum level or service id to activate the handler, defaults to WARNING.')->end() // fingers_crossed
                ->scalarNode('activation_strategy')->defaultNull()->info('Determines when the handler starts processing logs. Can be a log level or a service ID.')->end() // fingers_crossed
                ->booleanNode('stop_buffering')->defaultTrue()->info('Bool to disable buffering once the handler has been activated, defaults to true.')->end()// fingers_crossed
                ->scalarNode('passthru_level')->defaultNull()->info('Level name or int value for messages to always flush, disabled by default.')->end() // fingers_crossed
                ->arrayNode('excluded_404s') // fingers_crossed
                    ->canBeUnset()
                    ->prototype('scalar')->end()
                    ->info('If set, the strategy will be changed to one that excludes 404s coming from URLs matching any of those patterns.')
                ->end()
                ->arrayNode('excluded_http_codes') // fingers_crossed
                    ->canBeUnset()
                    ->info('If set, the strategy will be changed to one that excludes specific HTTP codes (requires Symfony Monolog bridge 4.1+).')
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
                ->scalarNode('buffer_size')->defaultValue(0)->info('Defaults to 0 (unlimited).')->end() // fingers_crossed
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::FINGERS_CROSSED;
    }
}
