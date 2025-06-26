<?php

declare(strict_types=1);

namespace Pest\Symfony\Kernel\Mailer;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Pest\Symfony\Constraint;
use Symfony\Component\Mailer\Event\MessageEvent;
use Symfony\Component\Mailer\Event\MessageEvents;
use Symfony\Component\Mailer\Test\Constraint as MailerConstraint;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Mime\Test\Constraint as MimeConstraint;

/**
 * @return MessageEvent[]
 */
function getEvents(?string $transport = null): array
{
    return test()->getMailerEvents($transport);
}

function getEvent(int $index = 0, ?string $transport = null): ?MessageEvent
{
    return test()->getMailerEvent($index, $transport);
}

/**
 * @return RawMessage[]
 */
function getMessages(?string $transport = null): array
{
    return test()->getMailerMessages($transport);
}

function getMessage(int $index = 0, ?string $transport = null): ?RawMessage
{
    return test()->getMailerMessage($index, $transport);
}

function getMessageEvents(): MessageEvents
{
    return test()->getMessageMailerEvents();
}

function extend(Expectation $expect): void
{
    $expect->extend('toBeEmailQueued', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new MailerConstraint\EmailIsQueued());

        return test();
    });

    $expect->extend('toHaveEmailCount', function (int $count, ?string $transport = null, bool $queued = false): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new MailerConstraint\EmailCount($count, $transport, $queued));

        return test();
    });

    $expect->extend('toHaveEmailAttachmentCount', function (int $count): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new MimeConstraint\EmailAttachmentCount($count));

        return test();
    });

    $expect->extend('toHaveEmailTextBody', function (string $text, bool $strict = true): HigherOrderTapProxy|TestCall {
        $contraint = match ($strict) {
            false => new MimeConstraint\EmailTextBodyContains($text),
            true => new Constraint\EmailTextBodySame($text),
        };

        expect($this->value)
            ->toMatchConstraint($contraint);

        return test();
    });

    $expect->extend('toHaveEmailHtmlBody', function (string $text, bool $strict = true): HigherOrderTapProxy|TestCall {
        $contraint = match ($strict) {
            false => new MimeConstraint\EmailHtmlBodyContains($text),
            true => new Constraint\EmailHtmlBodySame($text),
        };

        expect($this->value)
            ->toMatchConstraint($contraint);

        return test();
    });

    $expect->extend('toHaveEmailHeader', function (string $headerName, ?string $expectedValue = null, bool $strict = true): HigherOrderTapProxy|TestCall {
        $contraint = match (true) {
            1 === func_num_args() => new MimeConstraint\EmailHasHeader($headerName),
            default => new MimeConstraint\EmailHeaderSame($headerName, $expectedValue),
        };

        expect($this->value)
            ->toMatchConstraint($contraint);

        return test();
    });

    $expect->extend('toHaveEmailAddress', function (string $headerName, string $expectedValue, bool $strict = true): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new MimeConstraint\EmailAddressContains($headerName, $expectedValue));

        return test();
    });

    $expect->extend('toHaveEmailSubject', function (string $expectedValue, bool $strict = true): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new MimeConstraint\EmailSubjectContains($expectedValue));

        return test();
    });
}
