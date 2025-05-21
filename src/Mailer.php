<?php

declare(strict_types=1);

namespace Pest\Symfony\Mailer;

use Pest\Expectation;
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
    $expect->extend('toBeEmailCount', function (int $count, ?string $transport = null): void {
        $this->assertEmailCount($count, $transport);
    });

    $expect->extend('toBeQueuedEmailCount', function (int $count, ?string $transport = null): void {
        $this->assertQueuedEmailCount($count, $transport);
    });

    $expect->extend('toBeEmailIsQueued', function (MessageEvent $event): void {
        $this->assertEmailIsQueued($event);
    });

    $expect->extend('toBeEmailAttachmentCount', function (RawMessage $email, int $count): void {
        $this->assertEmailAttachmentCount($email, $count);
    });

    $expect->extend('toBeEmailTextBodyContains', function (RawMessage $email, string $text): void {
        $this->assertEmailTextBodyContains($email, $text);
    });

    $expect->extend('toBeEmailHtmlBodyContains', function (RawMessage $email, string $text): void {
        $this->assertEmailHtmlBodyContains($email, $text);
    });

    $expect->extend('toBeEmailHasHeader', function (RawMessage $email, string $headerName): void {
        $this->assertEmailHasHeader($email, $headerName);
    });

    $expect->extend('toBeEmailHeaderSame', function (RawMessage $email, string $headerName, string $expectedValue): void {
        $this->assertEmailHeaderSame($email, $headerName, $expectedValue);
    });

    $expect->extend('toBeEmailAddressContains', function (RawMessage $email, string $headerName, string $expectedValue): void {
        $this->assertEmailAddressContains($email, $headerName, $expectedValue);
    });

    $expect->extend('toBeEmailSubjectContains', function (RawMessage $email, string $expectedValue): void {
        $this->assertEmailSubjectContains($email, $expectedValue);
    });
}
