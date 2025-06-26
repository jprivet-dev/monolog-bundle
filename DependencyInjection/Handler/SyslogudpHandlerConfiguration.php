<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class SyslogudpHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->scalarNode('ident')->defaultFalse()->end() // syslogudp
                ->scalarNode('facility')->defaultValue('user')->end() // syslogudp
                ->scalarNode('logopts')->defaultValue(\LOG_PID)->end() // syslogudp
                ->scalarNode('host')->defaultNull()->end() // syslogudp
                ->scalarNode('port')->defaultValue(514)->end() // syslogudp
            ->end()
        ;

        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'syslogudp' === $v['type'] && !isset($v['host']); })
                    ->thenInvalid('The host has to be specified to use a syslogudp as handler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::SYSLOGUDP;
    }
}
