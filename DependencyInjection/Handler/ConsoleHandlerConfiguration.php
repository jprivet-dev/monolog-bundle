<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class ConsoleHandlerConfiguration extends AbstractHandlerConfiguration
{
    static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->arrayNode('process_psr_3_messages') // console
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
            ->end()
        ;

        if($legacy) {
            $node
                ->children()
                    ->variableNode('console_formater_options')
                        ->setDeprecated('symfony/monolog-bundle', 3.7, '"%path%.%node%" is deprecated, use "%path%.console_formatter_options" instead.')
                        ->validate()
                            ->ifTrue(function ($v) {
                                return !\is_array($v);
                            })
                            ->thenInvalid('The console_formater_options must be an array.')
                        ->end()
                    ->end()
                ->end()
            ;
        }

        $node
            ->children()
                ->variableNode('console_formatter_options')
                    ->defaultValue([])
                    ->validate()
                        ->ifTrue(static function ($v) { return !\is_array($v); })
                        ->thenInvalid('The console_formatter_options must be an array.')
                    ->end()
                ->end()
            ->end()
        ;

        if($legacy) {
            $node
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
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::CONSOLE;
    }
}
