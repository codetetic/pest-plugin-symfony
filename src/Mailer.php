<?php

declare(strict_types=1);

namespace Pest\Symfony\Mailer;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Mailer\Event\MessageEvent;
use Symfony\Component\Mailer\Event\MessageEvents;
use Symfony\Component\Mailer\Test\Constraint as MailerConstraint;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Mime\Test\Constraint as MimeConstraint;

/**
 * @return MessageEvent[]
 */
function getMailerEvents(?string $transport = null): array
{
    return test()->getMailerEvents($transport);
}

function getMailerEvent(int $index = 0, ?string $transport = null): ?MessageEvent
{
    return test()->getMailerEvent($index, $transport);
}

/**
 * @return RawMessage[]
 */
function getMailerMessages(?string $transport = null): array
{
    return test()->getMailerMessages($transport);
}

function getMailerMessage(int $index = 0, ?string $transport = null): ?RawMessage
{
    return test()->getMailerMessage($index, $transport);
}

function getMessageMailerEvents(): MessageEvents
{
    return test()->getMessageMailerEvents();
}

function extend(Expectation $expect): void
{
    function unwrap(mixed $value, string $class): mixed
    {
        return match (true) {
            $value instanceof KernelTestCase => match ($class) {
                MessageEvents::class.'[]' => getMessageMailerEvents(),
            },
            default => $value,
        };
    }

    $expect->extend('assertEmailCount', function (int $count, ?string $transport = null): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, MessageEvents::class.'[]'))
            ->toBeInstanceOf(MessageEvents::class)
            ->toMatchConstraint(new MailerConstraint\EmailCount($count, $transport));

        return test();
    });

    $expect->extend('assertQueuedEmailCount', function (int $count, ?string $transport = null): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, MessageEvents::class.'[]'))
            ->toBeInstanceOf(MessageEvents::class)
            ->toMatchConstraint(new MailerConstraint\EmailCount($count, $transport, true));

        return test();
    });

    $expect->extend('assertEmailIsQueued', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toBeInstanceOf(MessageEvent::class)
            ->toMatchConstraint(new MailerConstraint\EmailIsQueued());

        return test();
    });

    $expect->extend('assertEmailAttachmentCount', function (int $count): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toBeInstanceOf(RawMessage::class)
            ->toMatchConstraint(new MimeConstraint\EmailAttachmentCount($count));

        return test();
    });

    $expect->extend('assertEmailTextBodyContains', function (string $text): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toBeInstanceOf(RawMessage::class)
            ->toMatchConstraint(new MimeConstraint\EmailTextBodyContains($text));

        return test();
    });

    $expect->extend('assertEmailHtmlBodyContains', function (string $text): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toBeInstanceOf(RawMessage::class)
            ->toMatchConstraint(new MimeConstraint\EmailHtmlBodyContains($text));

        return test();
    });

    $expect->extend('assertEmailHasHeader', function (string $headerName): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toBeInstanceOf(RawMessage::class)
            ->toMatchConstraint(new MimeConstraint\EmailHasHeader($headerName));

        return test();
    });

    $expect->extend('assertEmailHeaderSame', function (string $headerName, string $expectedValue): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toBeInstanceOf(RawMessage::class)
            ->toMatchConstraint(new MimeConstraint\EmailHeaderSame($headerName, $expectedValue));

        return test();
    });

    $expect->extend('assertEmailAddressContains', function (string $headerName, string $expectedValue): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toBeInstanceOf(RawMessage::class)
            ->toMatchConstraint(new MimeConstraint\EmailAddressContains($headerName, $expectedValue));

        return test();
    });

    $expect->extend('assertEmailSubjectContains', function (string $expectedValue): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toBeInstanceOf(RawMessage::class)
            ->toMatchConstraint(new MimeConstraint\EmailSubjectContains($expectedValue));

        return test();
    });
}
