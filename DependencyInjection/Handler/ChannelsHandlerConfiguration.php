<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class ChannelsHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $channelsNode = $node
            ->children()
                ->arrayNode('channels')
                    ->fixXmlConfig('channel', 'elements')
                    ->canBeUnset()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return ['elements' => [$v]]; })
                    ->end()
                    ->beforeNormalization()
                        ->ifTrue(function ($v) { return \is_array($v) && is_numeric(key($v)); })
                        ->then(function ($v) { return ['elements' => $v]; })
                    ->end()
                    ->validate()
                        ->ifTrue(function ($v) { return empty($v); })
                        ->thenUnset()
                    ->end()
        ;

        if ($legacy) {
            $channelsNode
                ->validate()
                    ->always(function ($v) {
                        $isExclusive = null;
                        if (isset($v['type'])) {
                            $isExclusive = 'exclusive' === $v['type'];
                        }

                        $elements = [];
                        foreach ($v['elements'] as $element) {
                            if (0 === strpos($element, '!')) {
                                if (false === $isExclusive) {
                                    throw new InvalidConfigurationException('Cannot combine exclusive/inclusive definitions in channels list.');
                                }
                                $elements[] = substr($element, 1);
                                $isExclusive = true;
                            } else {
                                if (true === $isExclusive) {
                                    throw new InvalidConfigurationException('Cannot combine exclusive/inclusive definitions in channels list');
                                }
                                $elements[] = $element;
                                $isExclusive = false;
                            }
                        }

                        if (!\count($elements)) {
                            return null;
                        }

                        // de-duplicating $elements here in case the handlers are redefined, see https://github.com/symfony/monolog-bundle/issues/433
                        return ['type' => $isExclusive ? 'exclusive' : 'inclusive', 'elements' => array_unique($elements)];
                    })
                ->end()
            ;
        }

        $channelsNode
            ->children()
                ->scalarNode('type')
                    ->validate()
                        ->ifNotInArray(['inclusive', 'exclusive'])
                        ->thenInvalid('The type of channels has to be inclusive or exclusive')
                    ->end()
                ->end()
                ->arrayNode('elements')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::CHANNELS;
    }
}
