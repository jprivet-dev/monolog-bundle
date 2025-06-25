<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

class CubeHandlerConfiguration extends AbstractHandlerConfiguration
{
    static public function addOptions(NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node, bool $legacy = false): void
    {
        if($legacy) {
            $node
                ->validate()
                    ->ifTrue(function ($v) { return 'cube' === $v['type'] && empty($v['url']); })
                    ->thenInvalid('The url has to be specified to use a CubeHandler')
                ->end()
            ;
        }
    }

    public function getType(): HandlerType
    {
        return HandlerType::CUBE;
    }
}
