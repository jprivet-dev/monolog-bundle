<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class SlackwebhookHandlerConfiguration extends AbstractHandlerConfiguration
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
                    ->ifTrue(function ($v) { return 'slackwebhook' === $v['type'] && (empty($v['webhook_url'])); })
                    ->thenInvalid('The webhook_url have to be specified to use a SlackWebhookHandler')
                ->end()
            ;
        }
    }


    public function getType(): HandlerType
    {
        return HandlerType::SLACKWEBHOOK;
    }
}
