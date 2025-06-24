<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Enum;

use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\LegacyHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\StreamHandlerConfiguration;

enum HandlerType: string
{
    case LEGACY = 'legacy';
    case STREAM = 'stream';
//    case CONSOLE = 'console';
//    case FIREPHP = 'firephp';
//    case BROWSER_CONSOLE = 'browser_console';
//    case GELF = 'gelf';
//    case CHROMEPHP = 'chromephp';
//    case ROTATING_FILE = 'rotating_file';
//    case MONGO = 'mongo';
//    case ELASTICSEARCH = 'elasticsearch';
//    case ELASTICA = 'elastica';
//    case REDIS = 'redis';
//    case PREDIS = 'predis';
//    case FINGERS_CROSSED = 'fingers_crossed';
//    case FILTER = 'filter';
//    case BUFFER = 'buffer';
//    case DEDUPLICATION = 'deduplication';
//    case GROUP = 'group';
//    case WHATFAILUREGROUP = 'whatfailuregroup';
//    case FALLBACKGROUP = 'fallbackgroup';
//    case SYSLOG = 'syslog';
//    case SYSLOGUDP = 'syslogudp';
//    case SWIFT_MAILER = 'swift_mailer';
//    case NATIVE_MAILER = 'native_mailer';
//    case SYMFONY_MAILER = 'symfony_mailer';
//    case SOCKET = 'socket';
//    case PUSHOVER = 'pushover';
//    case RAVEN = 'raven';
//    case SENTRY = 'sentry';
//    case NEWRELIC = 'newrelic';
//    case HIPCHAT = 'hipchat';
//    case SLACK = 'slack';
//    case SLACKWEBHOOK = 'slackwebhook';
//    case SLACKBOT = 'slackbot';
//    case CUBE = 'cube';
//    case AMQP = 'amqp';
//    case ERROR_LOG = 'error_log';
//    case NULL = 'null';
//    case TEST = 'test';
//    case DEBUG = 'debug';
//    case LOGGLY = 'loggly';
//    case LOGENTRIES = 'logentries';
//    case INSIGHTOPS = 'insightops';
//    case FLOWDOCK = 'flowdock';
//    case ROLLBAR = 'rollbar';
//    case SERVER_LOG = 'server_log';
//    case TELEGRAM = 'telegram';
//    case SAMPLING = 'sampling';
//    case SERVICE = 'service';

    public function getHandlerConfigurationClass(): string
    {
        return match ($this) {
            self::LEGACY => LegacyHandlerConfiguration::class,
            self::STREAM => StreamHandlerConfiguration::class,
//            self::CONSOLE => ConsoleHandlerConfiguration::class,
//            self::FIREPHP => FirePhpHandlerConfiguration::class,
//            self::BROWSER_CONSOLE => BrowserConsoleHandlerConfiguration::class,
//            self::GELF => GelfHandlerConfiguration::class,
//            self::ROTATING_FILE => RotatingFileHandlerConfiguration::class,
//            self::MONGO => MongoHandlerConfiguration::class,
//            self::ELASTICSEARCH => ElasticsearchConsoleHandlerConfiguration::class,
//            self::ELASTICA => ElasticaConsoleHandlerConfiguration::class,
//            self::REDIS => RedisHandlerConfiguration::class,
//            self::PREDIS => PredisHandlerConfiguration::class,
//            self::FINGERS_CROSSED => FingerCrossedHandlerConfiguration::class,
//            self::FILTER => FilterHandlerConfiguration::class,
//            self::BUFFER => BufferHandlerConfiguration::class,
//            self::DEDUPLICATION => DeduplicationHandlerConfiguration::class,
//            self::GROUP => GroupHandlerConfiguration::class,
//            self::WHATFAILUREGROUP => WhatFailureGroupHandlerConfiguration::class,
//            self::FALLBACKGROUP => FallbackGroupHandlerConfiguration::class,
//            self::SYSLOG => SyslogHandlerConfiguration::class,
//            self::SYSLOGUDP => SyslogudpHandlerConfiguration::class,
//            self::CHROMEPHP => ChromePhpHandlerConfiguration::class,
//            self::SWIFT_MAILER => SwiftMailerHandlerConfiguration::class,
//            self::NATIVE_MAILER => NativeMailerHandlerConfiguration::class,
//            self::SYMFONY_MAILER => SymfonyMailerHandlerConfiguration::class,
//            self::SOCKET => SocketHandlerConfiguration::class,
//            self::PUSHOVER => PushoverHandlerConfiguration::class,
//            self::RAVEN => RavenHandlerConfiguration::class,
//            self::SENTRY => SentryHandlerConfiguration::class,
//            self::NEWRELIC => NewrelicHandlerConfiguration::class,
//            self::HIPCHAT => HipchatHandlerConfiguration::class,
//            self::SLACK => SlackHandlerConfiguration::class,
//            self::SLACKWEBHOOK => SlackWebhookHandlerConfiguration::class,
//            self::SLACKBOT => SlackbotHandlerConfiguration::class,
//            self::CUBE => CubeHandlerConfiguration::class,
//            self::AMQP => AmqpHandlerConfiguration::class,
//            self::ERROR_LOG => ErrorLogHandlerConfiguration::class,
//            self::NULL => NullHandlerConfiguration::class,
//            self::TEST => TestHandlerConfiguration::class,
//            self::DEBUG => DebugHandlerConfiguration::class,
//            self::LOGGLY => LogglyHandlerConfiguration::class,
//            self::LOGENTRIES => LogentriesHandlerConfiguration::class,
//            self::INSIGHTOPS => InsightOpsHandlerConfiguration::class,
//            self::FLOWDOCK => FlowdockHandlerConfiguration::class,
//            self::ROLLBAR => RollbarHandlerConfiguration::class,
//            self::SERVER_LOG => ServerLogHandlerConfiguration::class,
//            self::TELEGRAM => TelegramHandlerConfiguration::class,
//            self::SAMPLING => SamplingHandlerConfiguration::class,
//            self::SERVICE => ServiceHandlerConfiguration::class,
        };
    }
}
