<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class FingerscrossedHandlerConfiguration extends AbstractHandlerConfiguration
{
    static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
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
