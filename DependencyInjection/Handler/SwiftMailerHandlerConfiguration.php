<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class SwiftMailerHandlerConfiguration implements HandlerConfigurationInterface
{
    public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlerNode): void
    {
        $handlerNode
            ->children()
                ->scalarNode('from_email')->end() // swift_mailer
                ->arrayNode('to_email') // swift_mailer
                    ->prototype('scalar')->end()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return [$v]; })
                    ->end()
                ->end()
                ->scalarNode('subject')->end() // swift_mailer
                ->scalarNode('content_type')->defaultNull()->end() // swift_mailer
                ->scalarNode('mailer')->defaultNull()->end() // swift_mailer
                ->arrayNode('email_prototype') // swift_mailer
                    ->canBeUnset()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return ['id' => $v]; })
                    ->end()
                    ->children()
                        ->scalarNode('id')->isRequired()->end()
                        ->scalarNode('method')->defaultNull()->end()
                    ->end()
                ->end()
                ->booleanNode('lazy')->defaultValue(true)->end() // swift_mailer
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return 'swift_mailer' === $v['type'] && empty($v['email_prototype']) && (empty($v['from_email']) || empty($v['to_email']) || empty($v['subject'])); })
                ->thenInvalid('The sender, recipient and subject or an email prototype have to be specified to use a SwiftMailerHandler')
            ->end()
        ;
    }

    public function getType(): HandlerType
    {
        return HandlerType::SWIFT_MAILER;
    }
}
