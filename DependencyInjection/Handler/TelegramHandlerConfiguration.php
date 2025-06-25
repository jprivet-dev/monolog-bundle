<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class TelegramHandlerConfiguration extends AbstractHandlerConfiguration
{
    static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'telegram' === $v['type'] && (empty($v['token']) || empty($v['channel'])); })
                    ->thenInvalid('The token and channel have to be specified to use a TelegramBotHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::TELEGRAM;
    }
}
