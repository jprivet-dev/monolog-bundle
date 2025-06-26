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
    case AMQP = 'amqp';
    case BROWSER_CONSOLE = 'browser_console';
    case BUFFER = 'buffer';
    case CHANNELS = 'channels';
    case CHROMEPHP = 'chromephp';
    case CONSOLE = 'console';
    case CUBE = 'cube';
    case DEBUG = 'debug';
    case DEDUPLICATION = 'deduplication';
    case ELASTICA = 'elastica';
    case ELASTICSEARCH = 'elasticsearch';
    case ERROR_LOG = 'error_log';
    case FALLBACKGROUP = 'fallbackgroup';
    case FILTER = 'filter';
    case FINGERS_CROSSED = 'fingers_crossed';
    case FIREPHP = 'firephp';
    case FLOWDOCK = 'flowdock';
    case GELF = 'gelf';
    case GROUP = 'group';
    case HIPCHAT = 'hipchat';
    case INSIGHTOPS = 'insightops';
    case LOGENTRIES = 'logentries';
    case LOGGLY = 'loggly';
    case MONGO = 'mongo';
    case NATIVE_MAILER = 'native_mailer';
    case NEWRELIC = 'newrelic';
    case NULL = 'null';
    case PREDIS = 'predis';
    case PUSHOVER = 'pushover';
    case RAVEN = 'raven';
    case REDIS = 'redis';
    case ROLLBAR = 'rollbar';
    case ROTATING_FILE = 'rotating_file';
    case SAMPLING = 'sampling';
    case SENTRY = 'sentry';
    case SERVER_LOG = 'server_log';
    case SERVICE = 'service';
    case SLACK = 'slack';
    case SLACKBOT = 'slackbot';
    case SLACKWEBHOOK = 'slackwebhook';
    case SOCKET = 'socket';
    case STREAM = 'stream';
    case SWIFT_MAILER = 'swift_mailer';
    case SYMFONY_MAILER = 'symfony_mailer';
    case SYSLOG = 'syslog';
    case SYSLOGUDP = 'syslogudp';
    case TELEGRAM = 'telegram';
    case TEST = 'test';
    case VERBOSITY_LEVELS = 'verbosity_levels';
    case WHATFAILUREGROUP = 'whatfailuregroup';

    public function getHandlerConfigurationClass(): string
    {
        return match ($this) {
            self::AMQP => AmqpHandlerConfiguration::class,
            self::BROWSER_CONSOLE => BrowserconsoleHandlerConfiguration::class,
            self::BUFFER => BufferHandlerConfiguration::class,
            self::CHANNELS => ChannelsHandlerConfiguration::class,
            self::CHROMEPHP => ChromephpHandlerConfiguration::class,
            self::CONSOLE => ConsoleHandlerConfiguration::class,
            self::CUBE => CubeHandlerConfiguration::class,
            self::DEBUG => DebugHandlerConfiguration::class,
            self::DEDUPLICATION => DeduplicationHandlerConfiguration::class,
            self::ELASTICA => ElasticaHandlerConfiguration::class,
            self::ELASTICSEARCH => ElasticsearchHandlerConfiguration::class,
            self::ERROR_LOG => ErrorlogHandlerConfiguration::class,
            self::FALLBACKGROUP => FallbackgroupHandlerConfiguration::class,
            self::FILTER => FilterHandlerConfiguration::class,
            self::FINGERS_CROSSED => FingerscrossedHandlerConfiguration::class,
            self::FIREPHP => FirephpHandlerConfiguration::class,
            self::FLOWDOCK => FlowdockHandlerConfiguration::class,
            self::GELF => GelfHandlerConfiguration::class,
            self::GROUP => GroupHandlerConfiguration::class,
            self::HIPCHAT => HipchatHandlerConfiguration::class,
            self::INSIGHTOPS => InsightopsHandlerConfiguration::class,
            self::LOGENTRIES => LogentriesHandlerConfiguration::class,
            self::LOGGLY => LogglyHandlerConfiguration::class,
            self::MONGO => MongoHandlerConfiguration::class,
            self::NATIVE_MAILER => NativeMailerHandlerConfiguration::class,
            self::NEWRELIC => NewrelicHandlerConfiguration::class,
            self::NULL => NullHandlerConfiguration::class,
            self::PREDIS => PredisHandlerConfiguration::class,
            self::PUSHOVER => PushoverHandlerConfiguration::class,
            self::RAVEN => RavenHandlerConfiguration::class,
            self::REDIS => RedisHandlerConfiguration::class,
            self::ROLLBAR => RollbarHandlerConfiguration::class,
            self::ROTATING_FILE => RotatingfileHandlerConfiguration::class,
            self::SAMPLING => SamplingHandlerConfiguration::class,
            self::SENTRY => SentryHandlerConfiguration::class,
            self::SERVER_LOG => ServerlogHandlerConfiguration::class,
            self::SERVICE => ServiceHandlerConfiguration::class,
            self::SLACK => SlackHandlerConfiguration::class,
            self::SLACKBOT => SlackbotHandlerConfiguration::class,
            self::SLACKWEBHOOK => SlackwebhookHandlerConfiguration::class,
            self::SOCKET => SocketHandlerConfiguration::class,
            self::STREAM => StreamHandlerConfiguration::class,
            self::SWIFT_MAILER => SwiftMailerHandlerConfiguration::class,
            self::SYMFONY_MAILER => SymfonyMailerHandlerConfiguration::class,
            self::SYSLOG => SyslogHandlerConfiguration::class,
            self::SYSLOGUDP => SyslogudpHandlerConfiguration::class,
            self::TELEGRAM => TelegramHandlerConfiguration::class,
            self::TEST => TestHandlerConfiguration::class,
            self::VERBOSITY_LEVELS => VerbosityLevelHandlerConfiguration::class,
            self::WHATFAILUREGROUP => WhatfailuregroupHandlerConfiguration::class,
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            // --- Output Handlers ---
            self::STREAM => '[Output] Writes log records to a specified stream or file.',
            self::CONSOLE => '[Output] Writes log records to the console (Symfony Console output).',
            self::FIREPHP => '[Output] Sends log records to FirePHP in the browser console.',
            self::BROWSER_CONSOLE => '[Output] Sends log records to the browser JavaScript console.',
            self::GELF => '[Output] Sends log records to a Graylog Extended Log Format (GELF) server.',
            self::CHROMEPHP => '[Output] Sends log records to the ChromePHP extension.',
            self::ROTATING_FILE => '[Output] Writes log records to daily rotated files.',
            self::MONGO => '[Output] Writes log records to a MongoDB database.',
            self::ELASTICSEARCH => '[Output] Writes log records to an Elasticsearch server.',
            self::ELASTICA => '[Output] Writes log records to an Elasticsearch server using the Elastica client.',
            self::REDIS => '[Output] Writes log records to a Redis server.',
            self::PREDIS => '[Output] Writes log records to a Redis server using Predis.',
            self::SYSLOG => '[Output] Sends log records to the syslogd system logger.',
            self::SYSLOGUDP => '[Output] Sends log records to a remote syslogd server via UDP.',
            self::SWIFT_MAILER => '[Output] Sends log records via SwiftMailer.',
            self::NATIVE_MAILER => '[Output] Sends log records via PHP\'s native mail() function.',
            self::SYMFONY_MAILER => '[Output] Sends log records via Symfony Mailer.',
            self::SOCKET => '[Output] Sends log records over a network socket.',
            self::PUSHOVER => '[Output] Sends log records as Pushover notifications.',
            self::RAVEN => '[Output] Sends log records to a Sentry server (Raven client).',
            self::SENTRY => '[Output] Sends log records to a Sentry server (Sentry SDK).',
            self::NEWRELIC => '[Output] Sends log records to New Relic.',
            self::HIPCHAT => '[Output] Sends log records to HipChat.',
            self::SLACK => '[Output] Sends log records to Slack via a custom API token.',
            self::SLACKWEBHOOK => '[Output] Sends log records to Slack via a webhook.',
            self::SLACKBOT => '[Output] Sends log records to Slack via a Slackbot integration.',
            self::CUBE => '[Output] Sends log records to a Cube server.',
            self::AMQP => '[Output] Publishes log records to an AMQP exchange.',
            self::ERROR_LOG => '[Output] Sends log records to PHP\'s error_log function.',
            self::NULL => '[Output] Discards all log records.',
            self::TEST => '[Output] Collects log records in memory for testing.',
            self::DEBUG => '[Output] Sends all log records to the Symfony debug bar.',
            self::LOGGLY => '[Output] Sends log records to Loggly.',
            self::LOGENTRIES => '[Output] Sends log records to Logentries.',
            self::INSIGHTOPS => '[Output] Sends log records to InsightOps (formerly Logentries).',
            self::FLOWDOCK => '[Output] Sends log records to Flowdock.',
            self::ROLLBAR => '[Output] Sends log records to Rollbar.',
            self::SERVER_LOG => '[Output] Sends log records to the Symfony VarDumper server for real-time debugging.',
            self::TELEGRAM => '[Output] Sends log records as Telegram messages.',
            self::SERVICE => '[Output] References an existing service as the Monolog handler.',

            // --- Wrapper / Composite Handlers ---
            // Filtering Wrappers
            self::FILTER => '[Filtering] Passes records to nested handler if level matches criteria. Requires nested handler.',
            self::VERBOSITY_LEVELS => '[Filtering] Activates nested handler if Symfony Console verbosity is sufficient. Requires nested handler.',
            self::CHANNELS => '[Filtering] Passes records to nested handler if they belong to specific channels. Requires nested handler.',

            // Buffering Wrappers
            self::BUFFER => '[Buffering] Accumulates records, flushes to nested handler under conditions (e.g., buffer full, shutdown). Requires nested handler.',
            self::FINGERS_CROSSED => '[Buffering] Buffers records, flushes to nested handler when action level reached. Requires nested handler.',

            // Deduplication Wrappers
            self::DEDUPLICATION => '[Deduplication] Prevents duplicate records to nested handler within timeframe. Requires nested handler.',

            // Grouping Wrappers
            self::GROUP => '[Grouping] Sends all records to multiple nested handlers simultaneously. Requires one or more nested handlers.',
            self::WHATFAILUREGROUP => '[Grouping] Attempts sending records to first working nested handler, falls back on failure. Requires one or more nested handlers.',
            self::FALLBACKGROUP => '[Grouping] Sends records to first nested handler, falls back if it fails. Requires one or more nested handlers.',

            // Sampling Wrappers
            self::SAMPLING => '[Sampling] Passes a fraction of records to nested handler based on factor. Requires nested handler.',
        };
    }

    public function withTypePrefix(): string
    {
        return 'type_'.$this->value;
    }
}
