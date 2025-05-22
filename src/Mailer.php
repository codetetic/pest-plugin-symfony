<?php

declare(strict_types=1);

namespace Pest\Symfony\Mailer;

use Pest\Expectation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Mailer\Event\MessageEvent;
use Symfony\Component\Mime\RawMessage;

/**
 * @return MessageEvent[]
 */
function getMailerEvents(?string $transport = null): array
{
    return test()->getMessageMailerEvents()->getEvents($transport);
}

function getMailerEvent(int $index = 0, ?string $transport = null): ?MessageEvent
{
    return test()->getMailerEvents($transport)[$index] ?? null;
}

/**
 * @return RawMessage[]
 */
function getMailerMessages(?string $transport = null): array
{
    return test()->getMessageMailerEvents()->getMessages($transport);
}

function getMailerMessage(int $index = 0, ?string $transport = null): ?RawMessage
{
    return test()->getMailerMessages($transport)[$index] ?? null;
}

function extend(Expectation $expect): void
{
    function runner(WebTestCase $test, string $method, array $arguments = []): WebTestCase
    {
        call_user_func([$test, $method], ...$arguments);
        return $test;
    }

    $expect->extend('toBeEmailCount', function (int $count, ?string $transport = null): WebTestCase {
        return runner(test(), 'assertEmailCount', [$count, $transport]);
    });

    $expect->extend('toBeQueuedEmailCount', function (int $count, ?string $transport = null): WebTestCase {
        return runner(test(), 'assertQueuedEmailCount', [$count, $transport]);
    });

    $expect->extend('toBeEmailIsQueued', function (MessageEvent $event): WebTestCase {
        return runner(test(), 'assertEmailIsQueued', [$event]);
    });

    $expect->extend('toBeEmailAttachmentCount', function (RawMessage $email, int $count): WebTestCase {
        return runner(test(), 'assertEmailAttachmentCount', [$email, $count]);
    });

    $expect->extend('toBeEmailTextBodyContains', function (RawMessage $email, string $text): WebTestCase {
        return runner(test(), 'assertEmailTextBodyContains', [$email, $text]);
    });

    $expect->extend('toBeEmailHtmlBodyContains', function (RawMessage $email, string $text): WebTestCase {
        return runner(test(), 'assertEmailHtmlBodyContains', [$email, $text]);
    });

    $expect->extend('toBeEmailHasHeader', function (RawMessage $email, string $headerName): WebTestCase {
        return runner(test(), 'assertEmailHasHeader', [$email, $headerName]);
    });

    $expect->extend('toBeEmailHeaderSame', function (RawMessage $email, string $headerName, string $expectedValue): WebTestCase {
        return runner(test(), 'assertEmailHeaderSame', [$email, $headerName, $expectedValue]);
    });

    $expect->extend('toBeEmailAddressContains', function (RawMessage $email, string $headerName, string $expectedValue): WebTestCase {
        return runner(test(), 'assertEmailAddressContains', [$email, $headerName, $expectedValue]);
    });

    $expect->extend('toBeEmailSubjectContains', function (RawMessage $email, string $expectedValue): WebTestCase {
        return runner(test(), 'assertEmailSubjectContains', [$email, $expectedValue]);
    });
}
