<?php

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Enum;

use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\AmqpHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\BrowserConsoleHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\BufferHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ChannelsHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ChromePHPHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ConsoleHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\CubeHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\DebugHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\DeduplicationHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ElasticaHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ElasticsearchHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ErrorLogHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FallbackGroupHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FilterHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FingersCrossedHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FirePHPHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\FlowdockHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\GelfHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\GroupHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\HipchatHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\InsightOpsHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\LogEntriesHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\LogglyHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\MongoHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\NativeMailerHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\NewRelicHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\NoopHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\NullHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\PredisHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\PushoverHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\RavenHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\RedisHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\RollbarHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\RotatingFileHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SamplingHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SentryHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ServerlogHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\ServiceHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SlackbotHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SlackHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SlackWebhookHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SocketHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\StreamHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SwiftMailerHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SymfonyMailerHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SyslogHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\SysLogUdpHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\TelegramBotHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\TestHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\VerbosityLevelHandlerConfiguration;
use Symfony\Bundle\MonologBundle\DependencyInjection\Handler\WhatFailureGroupHandlerConfiguration;

enum HandlerType: string
{
    public const TYPE_PREFIX = 'type_';

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
    case ELASTIC_SEARCH = 'elastic_search';
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
    case NOOP = 'noop';
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
            self::BROWSER_CONSOLE => BrowserConsoleHandlerConfiguration::class,
            self::BUFFER => BufferHandlerConfiguration::class,
            self::CHANNELS => ChannelsHandlerConfiguration::class,
            self::CHROMEPHP => ChromePHPHandlerConfiguration::class,
            self::CONSOLE => ConsoleHandlerConfiguration::class,
            self::CUBE => CubeHandlerConfiguration::class,
            self::DEBUG => DebugHandlerConfiguration::class,
            self::DEDUPLICATION => DeduplicationHandlerConfiguration::class,
            self::ELASTICA => ElasticaHandlerConfiguration::class,
            self::ELASTIC_SEARCH => ElasticsearchHandlerConfiguration::class,
            self::ERROR_LOG => ErrorLogHandlerConfiguration::class,
            self::FALLBACKGROUP => FallbackGroupHandlerConfiguration::class,
            self::FILTER => FilterHandlerConfiguration::class,
            self::FINGERS_CROSSED => FingersCrossedHandlerConfiguration::class,
            self::FIREPHP => FirePHPHandlerConfiguration::class,
            self::FLOWDOCK => FlowdockHandlerConfiguration::class,
            self::GELF => GelfHandlerConfiguration::class,
            self::GROUP => GroupHandlerConfiguration::class,
            self::HIPCHAT => HipchatHandlerConfiguration::class,
            self::INSIGHTOPS => InsightOpsHandlerConfiguration::class,
            self::LOGENTRIES => LogEntriesHandlerConfiguration::class,
            self::LOGGLY => LogglyHandlerConfiguration::class,
            self::MONGO => MongoHandlerConfiguration::class,
            self::NATIVE_MAILER => NativeMailerHandlerConfiguration::class,
            self::NEWRELIC => NewRelicHandlerConfiguration::class,
            self::NOOP => NoopHandlerConfiguration::class,
            self::NULL => NullHandlerConfiguration::class,
            self::PREDIS => PredisHandlerConfiguration::class,
            self::PUSHOVER => PushoverHandlerConfiguration::class,
            self::RAVEN => RavenHandlerConfiguration::class,
            self::REDIS => RedisHandlerConfiguration::class,
            self::ROLLBAR => RollbarHandlerConfiguration::class,
            self::ROTATING_FILE => RotatingFileHandlerConfiguration::class,
            self::SAMPLING => SamplingHandlerConfiguration::class,
            self::SENTRY => SentryHandlerConfiguration::class,
            self::SERVER_LOG => ServerlogHandlerConfiguration::class,
            self::SERVICE => ServiceHandlerConfiguration::class,
            self::SLACK => SlackHandlerConfiguration::class,
            self::SLACKBOT => SlackbotHandlerConfiguration::class,
            self::SLACKWEBHOOK => SlackWebhookHandlerConfiguration::class,
            self::SOCKET => SocketHandlerConfiguration::class,
            self::STREAM => StreamHandlerConfiguration::class,
            self::SWIFT_MAILER => SwiftMailerHandlerConfiguration::class,
            self::SYMFONY_MAILER => SymfonyMailerHandlerConfiguration::class,
            self::SYSLOG => SyslogHandlerConfiguration::class,
            self::SYSLOGUDP => SysLogUdpHandlerConfiguration::class,
            self::TELEGRAM => TelegramBotHandlerConfiguration::class,
            self::TEST => TestHandlerConfiguration::class,
            self::VERBOSITY_LEVELS => VerbosityLevelHandlerConfiguration::class,
            self::WHATFAILUREGROUP => WhatFailureGroupHandlerConfiguration::class,
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            // --- Output Handlers ---
            self::AMQP => '[Output] Publishes log records to an AMQP exchange.',
            self::BROWSER_CONSOLE => '[Output] Sends log records to the browser JavaScript console.',
            self::CHROMEPHP => '[Output] Sends log records to the ChromePHP extension.',
            self::CONSOLE => '[Output] Writes log records to the console (Symfony Console output).',
            self::CUBE => '[Output] Sends log records to a Cube server.',
            self::DEBUG => '[Output] Sends all log records to the Symfony debug bar.',
            self::ELASTICA => '[Output] Writes log records to an Elasticsearch server using the Elastica client.',
            self::ELASTIC_SEARCH => '[Output] Writes log records to an Elasticsearch server.',
            self::ERROR_LOG => '[Output] Sends log records to PHP\'s error_log function.',
            self::FIREPHP => '[Output] Sends log records to FirePHP in the browser console.',
            self::FLOWDOCK => '[Output] Sends log records to Flowdock.',
            self::GELF => '[Output] Sends log records to a Graylog Extended Log Format (GELF) server.',
            self::HIPCHAT => '[Output] Sends log records to HipChat.',
            self::INSIGHTOPS => '[Output] Sends log records to InsightOps (formerly Logentries).',
            self::LOGENTRIES => '[Output] Sends log records to Logentries.',
            self::LOGGLY => '[Output] Sends log records to Loggly.',
            self::MONGO => '[Output] Writes log records to a MongoDB database.',
            self::NATIVE_MAILER => '[Output] Sends log records via PHP\'s native mail() function.',
            self::NEWRELIC => '[Output] Sends log records to New Relic.',
            self::NOOP => '[Output] A placeholder handler that discards all log messages, allowing temporary disablement.',
            self::NULL => '[Output] A handler that permanently discards all log messages.',
            self::PREDIS => '[Output] Writes log records to a Redis server using the Predis library.',
            self::PUSHOVER => '[Output] Sends log records as Pushover notifications.',
            self::RAVEN => '[Output] Sends log records to a Sentry server (using the deprecated Raven client).',
            self::REDIS => '[Output] Writes log records to a Redis server.',
            self::ROLLBAR => '[Output] Sends log records to Rollbar.',
            self::ROTATING_FILE => '[Output] Writes log records to daily rotated files.',
            self::SENTRY => '[Output] Sends log records to a Sentry server (Sentry SDK).',
            self::SERVER_LOG => '[Output] Sends log records to the Symfony VarDumper server for real-time debugging.',
            self::SERVICE => '[Output] References an existing service as the Monolog handler.',
            self::SLACK => '[Output] Sends log records to Slack via a custom API token.',
            self::SLACKBOT => '[Output] Sends log records to Slack via a Slackbot integration.',
            self::SLACKWEBHOOK => '[Output] Sends log records to Slack via a webhook.',
            self::SOCKET => '[Output] Sends log records over a network socket.',
            self::STREAM => '[Output] Writes log records to a specified stream or file.',
            self::SWIFT_MAILER => '[Output] Sends log records via SwiftMailer.',
            self::SYMFONY_MAILER => '[Output] Sends log records via Symfony Mailer.',
            self::SYSLOG => '[Output] Sends log records to the syslogd system logger.',
            self::SYSLOGUDP => '[Output] Sends log records to a remote syslogd server via UDP.',
            self::TELEGRAM => '[Output] Sends log records as Telegram messages.',
            self::TEST => '[Output] Collects log records in memory for testing.',

            // --- Wrapper / Composite Handlers ---
            // Filtering Wrappers
            self::CHANNELS => '[Filtering] Passes records to nested handler if they belong to specific channels. Requires nested handler.',
            self::FILTER => '[Filtering] Passes records to nested handler if level matches criteria. Requires nested handler.',
            self::VERBOSITY_LEVELS => '[Filtering] Passes records to nested handler based on Symfony Console verbosity.',

            // Buffering Wrappers
            self::BUFFER => '[Buffering] Accumulates records, flushes to nested handler under conditions (e.g., buffer full, shutdown). Requires nested handler.',
            self::FINGERS_CROSSED => '[Buffering] Buffers records, flushes to nested handler when action level reached. Requires nested handler.',

            // Deduplication Wrappers
            self::DEDUPLICATION => '[Deduplication] Prevents identical log records from being passed to the nested handler within a specific time.',

            // Grouping Wrappers
            self::GROUP => '[Grouping] Sends all records to multiple nested handlers simultaneously. Requires one or more nested handlers.',
            self::FALLBACKGROUP => '[Grouping] Sends records to the first nested handler, falls back to the next if it fails.',
            self::WHATFAILUREGROUP => '[Grouping] Attempts to send records to all nested handlers, logs failure if none succeed.',

            // Sampling Wrappers
            self::SAMPLING => '[Sampling] Passes a fraction of records to nested handler based on factor. Requires nested handler.',
        };
    }

    public function withTypePrefix(): string
    {
        return self::TYPE_PREFIX.$this->value;
    }

    public static function fromTypePrefix(string $typePrefix): self
    {
        if (!str_starts_with($typePrefix, self::TYPE_PREFIX)) {
            throw new \InvalidArgumentException(\sprintf('The type prefix "%s" does not start with "%s".', $typePrefix, self::TYPE_PREFIX));
        }

        $value = substr($typePrefix, \strlen(self::TYPE_PREFIX));

        return self::from($value);
    }
}
