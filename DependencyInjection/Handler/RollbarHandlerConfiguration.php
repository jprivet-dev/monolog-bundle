<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class RollbarHandlerConfiguration extends AbstractHandlerConfiguration
{
    public function __invoke(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        static::addOptions($this->typeNode($handlerNode));
    }

    static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'rollbar' === $v['type'] && !empty($v['id']) && !empty($v['token']); })
                    ->thenInvalid('You can not use both an id and a token in a RollbarHandler')
                ->end()
                ->validate()
                    ->ifTrue(function ($v) { return 'rollbar' === $v['type'] && empty($v['id']) && empty($v['token']); })
                    ->thenInvalid('The id or the token has to be specified to use a RollbarHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::ROLLBAR;
    }
}
