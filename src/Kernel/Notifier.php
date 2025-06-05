<?php

declare(strict_types=1);

namespace Pest\Symfony\Kernel\Notifier;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Symfony\Component\Notifier\Event\MessageEvent;
use Symfony\Component\Notifier\Event\NotificationEvents;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Test\Constraint as NotifierConstraint;

/**
 * @return MessageEvent[]
 */
function getEvents(?string $transportName = null): array
{
    return test()->getNotifierEvents($transportName);
}

function getEvent(int $index = 0, ?string $transportName = null): ?MessageEvent
{
    return test()->getNotifierEvent($index, $transportName);
}

/**
 * @return MessageInterface[]
 */
function getMessages(?string $transportName = null): array
{
    return test()->getNotifierMessages($transportName);
}

function getMessage(int $index = 0, ?string $transportName = null): ?MessageInterface
{
    return test()->getNotifierMessage($index, $transportName);
}

function getNotificationEvents(): NotificationEvents
{
    return test()->getNotificationEvents();
}

function extend(Expectation $expect): void
{
    $expect->extend('toHaveNotificationCount', function (int $count, ?string $transport = null, bool $queued = false): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new NotifierConstraint\NotificationCount($count, $transport, $queued));

        return test();
    });

    $expect->extend('isNotificationQueued', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new NotifierConstraint\NotificationIsQueued());

        return test();
    });

    $expect->extend('toHaveNotificationSubject', function (string $subject, bool $strict = false): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new NotifierConstraint\NotificationSubjectContains($subject));

        return test();
    });

    $expect->extend('toHaveNotificationTransport', function (?string $transportName = null): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new NotifierConstraint\NotificationTransportIsEqual($transportName));

        return test();
    });
}
