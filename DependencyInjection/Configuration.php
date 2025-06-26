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
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\HandlerConfigurationInterface;
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

        // --- Legacy linear options ---

        $handlerNode
            ->children()
                ->scalarNode('type')
                    ->isRequired()
                    ->treatNullLike('null')
                    ->beforeNormalization()
                        ->always()
                        ->then(function ($v) { return strtolower($v); })
                    ->end()
                ->end()
            ->end();


        foreach (HandlerType::cases() as $type) {
            $this->addCommonOptions($handlerNode);
            $this->getHandlerConfiguration($type)->addOptions($handlerNode, true);
        }

        // --- Options by handler configuration ---

        foreach (HandlerType::cases() as $type) {
            $description = sprintf('Define a "%s" handler (one type of handler per name and per environment).'.PHP_EOL.'%s', $type->value, $type->getDescription());

            $typeNode = $handlerNode
                ->children()
                    ->arrayNode($type->withTypePrefix())
                        ->canBeUnset()
                        ->info($description)
            ;

            $this->addCommonOptions($typeNode);
            $this->getHandlerConfiguration($type)->addOptions($typeNode);
        }

        return $treeBuilder;
    }

    private function addCommonOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node): void
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

    private function getHandlerConfiguration(HandlerType $type): HandlerConfigurationInterface
    {
        $class = $type->getHandlerConfigurationClass();

        if (!$class) {
            throw new \RuntimeException(\sprintf('The handler configuration "%s" is not registered.', $type->value));
        }

        if (!class_exists($class)) {
            throw new \RuntimeException(\sprintf('The class "%s" does not exist.', $class));
        }

        $handlerConfiguration = new $class();

        if (!$handlerConfiguration instanceof HandlerConfigurationInterface) {
            throw new \RuntimeException(\sprintf('Expected class of type "%s", "%s" given', HandlerConfigurationInterface::class, $class));
        }

        return $handlerConfiguration;
    }
}
