<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

abstract class AbstractHandlerConfiguration
{
    protected function typeNode(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): ArrayNodeDefinition
    {
        $typeName = $this->getType()->value;

        return $handlerNode
            ->children()
                ->arrayNode('type_'.$typeName)
                    ->canBeUnset()
                    ->info(sprintf('"%s" type handler (one type of handler per name and per environment).', $typeName))
        ;
    }

    abstract public function __invoke(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void;

    abstract public function getType(): HandlerType;
}
