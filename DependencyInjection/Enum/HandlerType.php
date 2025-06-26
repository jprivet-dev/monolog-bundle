<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Enum;

use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\AmqpHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\BrowserconsoleHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\BufferHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ChannelsHandlerConfiguration;
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
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\LogentriesHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\LogglyHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\MongoHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\NativeMailerHandlerConfiguration;
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
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SwiftMailerHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SymfonyMailerHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SyslogHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SyslogudpHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\TelegramHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\TestHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\VerbosityLevelHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\WhatfailuregroupHandlerConfiguration;

enum HandlerType: string
{
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
    case VERBOSITY_LEVELS = 'verbosity_levels';
    case CHANNELS = 'channels';
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
            self::SWIFT_MAILER => SwiftMailerHandlerConfiguration::class,
            self::NATIVE_MAILER => NativeMailerHandlerConfiguration::class,
            self::SYMFONY_MAILER => SymfonyMailerHandlerConfiguration::class,
            self::VERBOSITY_LEVELS => VerbosityLevelHandlerConfiguration::class,
            self::CHANNELS => ChannelsHandlerConfiguration::class,
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

    public function getDescription(): string
    {
        return match ($this) {
            // --- Output Handlers ---
            self::STREAM => '[Output Handlers] Writes log records to a specified stream or file.',
            self::CONSOLE => '[Output Handlers] Writes log records to the console (Symfony Console output).',
            self::FIREPHP => '[Output Handlers] Sends log records to FirePHP in the browser console.',
            self::BROWSER_CONSOLE => '[Output Handlers] Sends log records to the browser JavaScript console.',
            self::GELF => '[Output Handlers] Sends log records to a Graylog Extended Log Format (GELF) server.',
            self::CHROMEPHP => '[Output Handlers] Sends log records to the ChromePHP extension.',
            self::ROTATING_FILE => '[Output Handlers] Writes log records to files that are rotated daily.',
            self::MONGO => '[Output Handlers] Writes log records to a MongoDB database.',
            self::ELASTICSEARCH => '[Output Handlers] Writes log records to an Elasticsearch server.',
            self::ELASTICA => '[Output Handlers] Writes log records to an Elasticsearch server using the Elastica client.',
            self::REDIS => '[Output Handlers] Writes log records to a Redis server.',
            self::PREDIS => '[Output Handlers] Writes log records to a Redis server using Predis.',
            self::SYSLOG => '[Output Handlers] Sends log records to the syslogd system logger.',
            self::SYSLOGUDP => '[Output Handlers] Sends log records to a remote syslogd server via UDP.',
            self::SWIFT_MAILER => '[Output Handlers] Sends log records via SwiftMailer.',
            self::NATIVE_MAILER => '[Output Handlers] Sends log records via PHP\'s native mail() function.',
            self::SYMFONY_MAILER => '[Output Handlers] Sends log records via Symfony Mailer.',
            self::SOCKET => '[Output Handlers] Sends log records over a network socket.',
            self::PUSHOVER => '[Output Handlers] Sends log records as Pushover notifications.',
            self::RAVEN => '[Output Handlers] Sends log records to a Sentry server (Raven client).',
            self::SENTRY => '[Output Handlers] Sends log records to a Sentry server (Sentry SDK).',
            self::NEWRELIC => '[Output Handlers] Sends log records to New Relic.',
            self::HIPCHAT => '[Output Handlers] Sends log records to HipChat.',
            self::SLACK => '[Output Handlers] Sends log records to Slack via a custom API token.',
            self::SLACKWEBHOOK => '[Output Handlers] Sends log records to Slack via a webhook.',
            self::SLACKBOT => '[Output Handlers] Sends log records to Slack via a Slackbot integration.',
            self::CUBE => '[Output Handlers] Sends log records to a Cube server.',
            self::AMQP => '[Output Handlers] publishes log records to an AMQP exchange.',
            self::ERROR_LOG => '[Output Handlers] Sends log records to PHP\'s error_log function.',
            self::NULL => '[Output Handlers] Discards all log records, effectively doing nothing.',
            self::TEST => '[Output Handlers] Primarily used for testing, collecting log records in memory.',
            self::DEBUG => '[Output Handlers] Sends all log records to the Symfony debug bar.',
            self::LOGGLY => '[Output Handlers] Sends log records to Loggly.',
            self::LOGENTRIES => '[Output Handlers] Sends log records to Logentries.',
            self::INSIGHTOPS => '[Output Handlers] Sends log records to InsightOps (formerly Logentries).',
            self::FLOWDOCK => '[Output Handlers] Sends log records to Flowdock.',
            self::ROLLBAR => '[Output Handlers] Sends log records to Rollbar.',
            self::SERVER_LOG => '[Output Handlers] Sends log records to the Symfony VarDumper server for real-time debugging.',
            self::TELEGRAM => '[Output Handlers] Sends log records as Telegram messages.',
            self::SERVICE => '[Output Handlers] references an existing service as the Monolog handler.',

            // --- Wrapper / Composite Handlers ---
            // Filtering Wrappers
            self::FILTER => '[Filtering Wrappers] Passes log records to a nested handler only if their level matches predefined criteria. It requires a nested handler.',
            self::VERBOSITY_LEVELS => '[Filtering Wrappers] Only activates a nested handler if the Symfony Console verbosity level is sufficient. It requires a nested handler.',
            self::CHANNELS => '[Filtering Wrappers] Passes log records to a nested handler only if they belong to specific Monolog channels. It requires a nested handler.',

            // Buffering Wrappers
            self::BUFFER => '[Buffering Wrappers] Accumulates log records and flushes them to a nested handler under specific conditions (e.g., buffer full, shutdown). It requires a nested handler.',
            self::FINGERS_CROSSED => '[Buffering Wrappers] Buffers log records and flushes them to a nested handler when a specific action level is reached. It requires a nested handler.',

            // Deduplication Wrappers
            self::DEDUPLICATION => '[Deduplication Wrappers] Prevents duplicate log records from being sent to a nested handler within a defined time frame. It requires a nested handler.',

            // Grouping Wrappers
            self::GROUP => '[Grouping Wrappers] Sends all log records to multiple nested handlers simultaneously. It requires one or more nested handlers.',
            self::WHATFAILUREGROUP => '[Grouping Wrappers] Attempts to send log records to the first working nested handler in a list, falling back to others if failures occur. It requires one or more nested handlers.',
            self::FALLBACKGROUP => '[Grouping Wrappers] Sends log records to the first nested handler, and if it fails, falls back to the next, similar to WhatFailureGroupHandler. It requires one or more nested handlers.',

            // Sampling Wrappers
            self::SAMPLING => '[Sampling Wrappers] Only passes a fraction of log records to a nested handler based on a configured factor. It requires a nested handler.',
        };
    }

    public function withTypePrefix(): string
    {
        return 'type_'.$this->value;
    }
}
