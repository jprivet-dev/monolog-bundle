<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class FingerscrossedHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->scalarNode('handler')->info('The wrapped handler\'s name.')->end() // fingers_crossed
                ->scalarNode('action_level')->defaultValue('WARNING')->info('Minimum level or service id to activate the handler, defaults to WARNING.')->end() // fingers_crossed
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

        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'fingers_crossed' === $v['type'] && empty($v['handler']); })
                    ->thenInvalid('The handler has to be specified to use a FingersCrossedHandler')
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
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::FINGERS_CROSSED;
    }
}
