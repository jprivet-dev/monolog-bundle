<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\AppendConfigurationInterface;
use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

abstract class AbstractHandlerConfiguration implements AppendConfigurationInterface
{
    protected function typeNode(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): ArrayNodeDefinition
    {
        return $handlerNode
            ->children()
                ->arrayNode($this->getType()->withTypePrefix())
                    ->canBeUnset()
                    ->info(sprintf('"%s" type handler (one type of handler per name and per environment).', $this->getType()->value))
        ;
    }

    abstract public function getType(): HandlerType;
}
