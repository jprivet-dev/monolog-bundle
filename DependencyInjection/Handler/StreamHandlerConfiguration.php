<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Handler;

use Monolog\Logger;
use Symfony\Bundle\MonologBundle\DependencyInjection\Enum\HandlerType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class StreamHandlerConfiguration extends AbstractHandlerConfiguration
{
    public function addLegacyOptions(): void
    {
    }

    public function addOptions(): void
    {
    }

    public function getType(): HandlerType
    {
        return HandlerType::STREAM;
    }
}
