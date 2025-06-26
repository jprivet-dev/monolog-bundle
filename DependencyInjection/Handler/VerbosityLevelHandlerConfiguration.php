<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Monolog\Logger;
use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class VerbosityLevelHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->arrayNode('verbosity_levels') // console
                    ->beforeNormalization()
                        ->ifArray()
                        ->then(function ($v) {
                            $map = [];
                            $verbosities = ['VERBOSITY_QUIET', 'VERBOSITY_NORMAL', 'VERBOSITY_VERBOSE', 'VERBOSITY_VERY_VERBOSE', 'VERBOSITY_DEBUG'];
                            // allow numeric indexed array with ascendning verbosity and lowercase names of the constants
                            foreach ($v as $verbosity => $level) {
                                if (\is_int($verbosity) && isset($verbosities[$verbosity])) {
                                    $map[$verbosities[$verbosity]] = strtoupper($level);
                                } else {
                                    $map[strtoupper($verbosity)] = strtoupper($level);
                                }
                            }

                            return $map;
                        })
                    ->end()
                    ->children()
                        ->scalarNode('VERBOSITY_QUIET')->defaultValue('ERROR')->end()
                        ->scalarNode('VERBOSITY_NORMAL')->defaultValue('WARNING')->end()
                        ->scalarNode('VERBOSITY_VERBOSE')->defaultValue('NOTICE')->end()
                        ->scalarNode('VERBOSITY_VERY_VERBOSE')->defaultValue('INFO')->end()
                        ->scalarNode('VERBOSITY_DEBUG')->defaultValue('DEBUG')->end()
                    ->end()
                    ->validate()
                        ->always(function ($v) {
                            $map = [];
                            foreach ($v as $verbosity => $level) {
                                $verbosityConstant = 'Symfony\Component\Console\Output\OutputInterface::'.$verbosity;

                                if (!\defined($verbosityConstant)) {
                                    throw new InvalidConfigurationException(\sprintf('The configured verbosity "%s" is invalid as it is not defined in Symfony\Component\Console\Output\OutputInterface.', $verbosity));
                                }

                                try {
                                    if (Logger::API === 3) {
                                        $level = Logger::toMonologLevel($level)->value;
                                    } else {
                                        $level = Logger::toMonologLevel(is_numeric($level) ? (int) $level : $level);
                                    }
                                } catch (\Psr\Log\InvalidArgumentException $e) {
                                    throw new InvalidConfigurationException(\sprintf('The configured minimum log level "%s" for verbosity "%s" is invalid as it is not defined in Monolog\Logger.', $level, $verbosity));
                                }

                                $map[\constant($verbosityConstant)] = $level;
                            }

                            return $map;
                        })
                    ->end()
                ->end()
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::VERBOSITY_LEVELS;
    }
}
