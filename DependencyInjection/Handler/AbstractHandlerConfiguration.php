<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Tests\Fixtures\Builder\VariableNodeDefinition;

abstract class AbstractHandlerConfiguration
{
    public function __construct(protected NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition $node)
    {
    }

    abstract public function addLegacyOptions(): void;

    abstract public function addOptions(): void;

    abstract public function getType(): HandlerType;
}
