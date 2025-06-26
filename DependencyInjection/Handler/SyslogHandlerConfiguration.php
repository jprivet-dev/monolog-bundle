<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class SyslogHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->scalarNode('ident')->defaultFalse()->end() // syslog
                ->scalarNode('facility')->defaultValue('user')->end() // syslog
                ->scalarNode('logopts')->defaultValue(\LOG_PID)->end() // syslog
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::SYSLOG;
    }
}
