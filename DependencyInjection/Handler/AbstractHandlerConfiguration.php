<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\AppendConfigurationInterface;
use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

abstract class AbstractHandlerConfiguration implements AppendConfigurationInterface
{
    public function __invoke(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $typeNode = $this->typeNode($handlerNode);
        static::addCommonOptions($typeNode);
        static::addOptions($typeNode);
    }

    protected function typeNode(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): ArrayNodeDefinition
    {
        return $handlerNode
            ->children()
                ->arrayNode($this->getType()->withTypePrefix())
                    ->canBeUnset()
                    ->info(sprintf('"%s" type handler (one type of handler per name and per environment).', $this->getType()->value))
        ;
    }

    static public function addCommonOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->scalarNode('priority')
                    ->defaultValue(0)
                    ->info('Defines the processing order; handlers with a higher priority value are executed first.')
                ->end()
                ->scalarNode('level')
                    ->defaultValue('DEBUG')
                    ->info('Level name or int value, defaults to DEBUG.')
                ->end()
                ->booleanNode('bubble')
                    ->defaultTrue()
                    ->info('When true, messages are passed to the next handler in the stack; when false, the chain ends here.')
                ->end()
                ->booleanNode('include_stacktraces')
                    ->defaultFalse()
                    ->info('When true, a full stack trace is included in the log record, especially for errors and exceptions.')
                ->end()
                ->booleanNode('nested')
                    ->defaultFalse()
                    ->info('When true, this handler is part of a nested handler configuration (e.g., as the primary handler of a FingersCrossedHandler).')
                ->end()
                ->scalarNode('formatter')
                    ->info('The formatter used to format the log records. Can be a service ID or a formatter configuration.')
                ->end()
            ->end()
        ;
    }

    abstract static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void;

    abstract public function getType(): HandlerType;
}
