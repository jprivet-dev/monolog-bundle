<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class HipchatHandlerConfiguration extends AbstractHandlerConfiguration
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
                    ->ifTrue(function ($v) { return 'hipchat' === $v['type'] && (empty($v['token']) || empty($v['room'])); })
                    ->thenInvalid('The token and room have to be specified to use a HipChatHandler')
                ->end()
                ->validate()
                    ->ifTrue(function ($v) { return 'hipchat' === $v['type'] && !\in_array($v['message_format'], ['text', 'html']); })
                    ->thenInvalid('The message_format has to be "text" or "html" in a HipChatHandler')
                ->end()
                ->validate()
                    ->ifTrue(function ($v) { return 'hipchat' === $v['type'] && null !== $v['api_version'] && !\in_array($v['api_version'], ['v1', 'v2'], true); })
                    ->thenInvalid('The api_version has to be "v1" or "v2" in a HipChatHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::HIPCHAT;
    }
}
