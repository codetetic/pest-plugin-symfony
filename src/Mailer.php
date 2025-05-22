<?php

declare(strict_types=1);

namespace Pest\Symfony\Mailer;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
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
    function runner(KernelTestCase $test, string $method, array $arguments = []): HigherOrderTapProxy|TestCall
    {
        call_user_func([$test, $method], ...$arguments);

        return test();
    }

    $expect->extend('toBeEmailCount', function (int $count, ?string $transport = null): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertEmailCount', [$count, $transport]);
    });

    $expect->extend('toBeQueuedEmailCount', function (int $count, ?string $transport = null): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertQueuedEmailCount', [$count, $transport]);
    });

    $expect->extend('toBeEmailIsQueued', function (MessageEvent $event): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertEmailIsQueued', [$event]);
    });

    $expect->extend('toBeEmailAttachmentCount', function (RawMessage $email, int $count): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertEmailAttachmentCount', [$email, $count]);
    });

    $expect->extend('toBeEmailTextBodyContains', function (RawMessage $email, string $text): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertEmailTextBodyContains', [$email, $text]);
    });

    $expect->extend('toBeEmailHtmlBodyContains', function (RawMessage $email, string $text): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertEmailHtmlBodyContains', [$email, $text]);
    });

    $expect->extend('toBeEmailHasHeader', function (RawMessage $email, string $headerName): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertEmailHasHeader', [$email, $headerName]);
    });

    $expect->extend('toBeEmailHeaderSame', function (RawMessage $email, string $headerName, string $expectedValue): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertEmailHeaderSame', [$email, $headerName, $expectedValue]);
    });

    $expect->extend('toBeEmailAddressContains', function (RawMessage $email, string $headerName, string $expectedValue): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertEmailAddressContains', [$email, $headerName, $expectedValue]);
    });

    $expect->extend('toBeEmailSubjectContains', function (RawMessage $email, string $expectedValue): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertEmailSubjectContains', [$email, $expectedValue]);
    });
}
