<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class LogglyHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->scalarNode('token')->end() // loggly
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
            ->end()
        ;

        if($legacy) {
            $node
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
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::LOGGLY;
    }
}
