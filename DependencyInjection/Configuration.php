<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MonologBundle\DependencyInjection;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\AbstractHandlerConfiguration;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @author Christophe Coevoet <stof@notk.org>
 *
 * @final since 3.9.0
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('monolog');
        $rootNode = $treeBuilder->getRootNode();

        $handlersNode = $rootNode
            ->fixXmlConfig('channel')
            ->fixXmlConfig('handler')
            ->children()
                ->scalarNode('use_microseconds')->defaultTrue()->end()
                ->arrayNode('channels')
                    ->canBeUnset()
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('handlers');

        $handlersNode
            ->canBeUnset()
            ->useAttributeAsKey('name')
            ->validate()
                ->ifTrue(function ($v) { return isset($v['debug']); })
                ->thenInvalid('The "debug" name cannot be used as it is reserved for the handler of the profiler')
            ->end()
            ->example([
                'syslog' => [
                    'type' => 'stream',
                    'path' => '/var/log/symfony.log',
                    'level' => 'ERROR',
                    'bubble' => 'false',
                    'formatter' => 'my_formatter',
                ],
                'main' => [
                    'type' => 'fingers_crossed',
                    'action_level' => 'WARNING',
                    'buffer_size' => 30,
                    'handler' => 'custom',
                ],
                'custom' => [
                    'type' => 'service',
                    'id' => 'my_handler',
                ],
            ]);

        $handlerNode = $handlersNode
            ->prototype('array')
                ->fixXmlConfig('member')
                ->fixXmlConfig('excluded_404')
                ->fixXmlConfig('excluded_http_code')
                ->fixXmlConfig('tag')
                ->fixXmlConfig('accepted_level')
                ->fixXmlConfig('header')
                ->canBeUnset();

        foreach (HandlerType::cases() as $type) {
            $this->addHandlerConfigurationByType($type, $handlerNode);
        }

        return $treeBuilder;
    }

    /**
     * Add a handler configuration from a handler type.
     */
    public function addHandlerConfigurationByType(HandlerType $type, NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $handlersNode): static
    {
        $class = $type->getHandlerConfigurationClass();

        if (!$class) {
            throw new \RuntimeException(\sprintf('The handler configuration "%s" is not registered.', $type->value));
        }

        if (!class_exists($class)) {
            throw new \RuntimeException(\sprintf('The class "%s" does not exist.', $class));
        }

        $configuration = new $class();

        if (!$configuration instanceof AbstractHandlerConfiguration) {
            throw new \RuntimeException(\sprintf('Expected class of type "%s", "%s" given', AbstractHandlerConfiguration::class, \get_debug_type($configuration)));
        }

        $configuration($handlersNode);

        return $this;
    }
}
