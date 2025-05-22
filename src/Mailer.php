<?php

declare(strict_types=1);

namespace Pest\Symfony\Mailer;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Mailer\Event\MessageEvent;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Mailer\Test\Constraint as MailerConstraint;
use Symfony\Component\Mime\Test\Constraint as MimeConstraint;

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
    $expect->extend('toBeEmailCount', function (int $count, ?string $transport = null): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new MailerConstraint\EmailCount($count, $transport)
        );
        return test();
    });

    $expect->extend('toBeQueuedEmailCount', function (int $count, ?string $transport = null): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new MailerConstraint\EmailCount($count, $transport, true)
        );
        return test();
    });

    $expect->extend('toBeEmailIsQueued', function (): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new MailerConstraint\EmailIsQueued()
        );
        return test();
    });

    $expect->extend('toBeEmailAttachmentCount', function (int $count): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new MimeConstraint\EmailAttachmentCount($count),
        );
        return test();
    });

    $expect->extend('toBeEmailTextBodyContains', function (string $text): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new MimeConstraint\EmailTextBodyContains($text)
        );
        return test();
    });

    $expect->extend('toBeEmailHtmlBodyContains', function (string $text): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new MimeConstraint\EmailHtmlBodyContains($text)
        );
        return test();
    });

    $expect->extend('toBeEmailHasHeader', function (string $headerName): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new MimeConstraint\EmailHasHeader($headerName)
        );
        return test();
    });

    $expect->extend('toBeEmailHeaderSame', function (string $headerName, string $expectedValue): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new MimeConstraint\EmailHeaderSame($headerName, $expectedValue)
        );
        return test();
    });

    $expect->extend('toBeEmailAddressContains', function (string $headerName, string $expectedValue): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new MimeConstraint\EmailAddressContains($headerName, $expectedValue)
        );
        return test();
    });

    $expect->extend('toBeEmailSubjectContains', function (string $expectedValue): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new MimeConstraint\EmailSubjectContains($expectedValue)
        );
        return test();
    });
}
