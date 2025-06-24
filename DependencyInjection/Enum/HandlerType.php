<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Enum;

use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\AmqpHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\BrowserconsoleHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\BufferHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ChromephpHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ConsoleHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\CubeHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\DebugHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\DeduplicationHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ElasticaHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ElasticsearchHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ErrorlogHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FallbackgroupHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FilterHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FingerscrossedHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FirephpHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FlowdockHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\GelfHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\GroupHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\HipchatHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\InsightopsHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\LegacyHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\LogentriesHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\LogglyHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\MongoHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\NativemailerHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\NewrelicHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\NullHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\PredisHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\PushoverHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\RavenHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\RedisHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\RollbarHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\RotatingfileHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SamplingHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SentryHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ServerlogHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ServiceHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SlackbotHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SlackHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SlackwebhookHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SocketHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\StreamHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SwiftmailerHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SymfonymailerHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SyslogHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SyslogudpHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\TelegramHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\TestHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\WhatfailuregroupHandlerConfiguration;

enum HandlerType: string
{
    case LEGACY = 'legacy';
    case STREAM = 'stream';
    case CONSOLE = 'console';
    case FIREPHP = 'firephp';
    case BROWSER_CONSOLE = 'browser_console';
    case GELF = 'gelf';
    case CHROMEPHP = 'chromephp';
    case ROTATING_FILE = 'rotating_file';
    case MONGO = 'mongo';
    case ELASTICSEARCH = 'elasticsearch';
    case ELASTICA = 'elastica';
    case REDIS = 'redis';
    case PREDIS = 'predis';
    case FINGERS_CROSSED = 'fingers_crossed';
    case FILTER = 'filter';
    case BUFFER = 'buffer';
    case DEDUPLICATION = 'deduplication';
    case GROUP = 'group';
    case WHATFAILUREGROUP = 'whatfailuregroup';
    case FALLBACKGROUP = 'fallbackgroup';
    case SYSLOG = 'syslog';
    case SYSLOGUDP = 'syslogudp';
    case SWIFT_MAILER = 'swift_mailer';
    case NATIVE_MAILER = 'native_mailer';
    case SYMFONY_MAILER = 'symfony_mailer';
    case SOCKET = 'socket';
    case PUSHOVER = 'pushover';
    case RAVEN = 'raven';
    case SENTRY = 'sentry';
    case NEWRELIC = 'newrelic';
    case HIPCHAT = 'hipchat';
    case SLACK = 'slack';
    case SLACKWEBHOOK = 'slackwebhook';
    case SLACKBOT = 'slackbot';
    case CUBE = 'cube';
    case AMQP = 'amqp';
    case ERROR_LOG = 'error_log';
    case NULL = 'null';
    case TEST = 'test';
    case DEBUG = 'debug';
    case LOGGLY = 'loggly';
    case LOGENTRIES = 'logentries';
    case INSIGHTOPS = 'insightops';
    case FLOWDOCK = 'flowdock';
    case ROLLBAR = 'rollbar';
    case SERVER_LOG = 'server_log';
    case TELEGRAM = 'telegram';
    case SAMPLING = 'sampling';
    case SERVICE = 'service';

    public function getHandlerConfigurationClass(): string
    {
        return match ($this) {
            self::LEGACY => LegacyHandlerConfiguration::class,
            self::STREAM => StreamHandlerConfiguration::class,
            self::CONSOLE => ConsoleHandlerConfiguration::class,
            self::FIREPHP => FirephpHandlerConfiguration::class,
            self::BROWSER_CONSOLE => BrowserconsoleHandlerConfiguration::class,
            self::GELF => GelfHandlerConfiguration::class,
            self::ROTATING_FILE => RotatingfileHandlerConfiguration::class,
            self::MONGO => MongoHandlerConfiguration::class,
            self::ELASTICSEARCH => ElasticsearchHandlerConfiguration::class,
            self::ELASTICA => ElasticaHandlerConfiguration::class,
            self::REDIS => RedisHandlerConfiguration::class,
            self::PREDIS => PredisHandlerConfiguration::class,
            self::FINGERS_CROSSED => FingerscrossedHandlerConfiguration::class,
            self::FILTER => FilterHandlerConfiguration::class,
            self::BUFFER => BufferHandlerConfiguration::class,
            self::DEDUPLICATION => DeduplicationHandlerConfiguration::class,
            self::GROUP => GroupHandlerConfiguration::class,
            self::WHATFAILUREGROUP => WhatfailuregroupHandlerConfiguration::class,
            self::FALLBACKGROUP => FallbackgroupHandlerConfiguration::class,
            self::SYSLOG => SyslogHandlerConfiguration::class,
            self::SYSLOGUDP => SyslogudpHandlerConfiguration::class,
            self::CHROMEPHP => ChromephpHandlerConfiguration::class,
            self::SWIFT_MAILER => SwiftmailerHandlerConfiguration::class,
            self::NATIVE_MAILER => NativemailerHandlerConfiguration::class,
            self::SYMFONY_MAILER => SymfonymailerHandlerConfiguration::class,
            self::SOCKET => SocketHandlerConfiguration::class,
            self::PUSHOVER => PushoverHandlerConfiguration::class,
            self::RAVEN => RavenHandlerConfiguration::class,
            self::SENTRY => SentryHandlerConfiguration::class,
            self::NEWRELIC => NewrelicHandlerConfiguration::class,
            self::HIPCHAT => HipchatHandlerConfiguration::class,
            self::SLACK => SlackHandlerConfiguration::class,
            self::SLACKWEBHOOK => SlackwebhookHandlerConfiguration::class,
            self::SLACKBOT => SlackbotHandlerConfiguration::class,
            self::CUBE => CubeHandlerConfiguration::class,
            self::AMQP => AmqpHandlerConfiguration::class,
            self::ERROR_LOG => ErrorlogHandlerConfiguration::class,
            self::NULL => NullHandlerConfiguration::class,
            self::TEST => TestHandlerConfiguration::class,
            self::DEBUG => DebugHandlerConfiguration::class,
            self::LOGGLY => LogglyHandlerConfiguration::class,
            self::LOGENTRIES => LogentriesHandlerConfiguration::class,
            self::INSIGHTOPS => InsightopsHandlerConfiguration::class,
            self::FLOWDOCK => FlowdockHandlerConfiguration::class,
            self::ROLLBAR => RollbarHandlerConfiguration::class,
            self::SERVER_LOG => ServerlogHandlerConfiguration::class,
            self::TELEGRAM => TelegramHandlerConfiguration::class,
            self::SAMPLING => SamplingHandlerConfiguration::class,
            self::SERVICE => ServiceHandlerConfiguration::class,
        };
    }
}
