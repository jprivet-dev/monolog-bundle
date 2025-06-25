<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class SymfonyMailerHandlerConfiguration extends AbstractHandlerConfiguration
{
    static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        $node
            ->children()
                ->scalarNode('from_email')->end() // swift_mailer, native_mailer, symfony_mailer and flowdock
                ->arrayNode('to_email') // swift_mailer, native_mailer and symfony_mailer
                    ->prototype('scalar')->end()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return [$v]; })
                    ->end()
                ->end()
                ->scalarNode('subject')->end() // swift_mailer, native_mailer and symfony_mailer
                ->scalarNode('content_type')->defaultNull()->end() // swift_mailer and symfony_mailer
                ->arrayNode('headers') // native_mailer
                    ->canBeUnset()
                    ->scalarPrototype()->end()
                ->end()
                ->scalarNode('mailer')->defaultNull()->end() // swift_mailer and symfony_mailer
                ->arrayNode('email_prototype') // swift_mailer and symfony_mailer
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
            ->end()
        ;

        if($legacy) {
              $node
                ->validate()
                    ->ifTrue(function ($v) { return 'symfony_mailer' === $v['type'] && empty($v['email_prototype']) && (empty($v['from_email']) || empty($v['to_email']) || empty($v['subject'])); })
                    ->thenInvalid('The sender, recipient and subject or an email prototype have to be specified to use the Symfony MailerHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::SYMFONY_MAILER;
    }
}
