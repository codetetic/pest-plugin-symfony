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
function getNotifierEvents(?string $transportName = null): array
{
    return test()->getNotifierEvents($transportName);
}

function getNotifierEvent(int $index = 0, ?string $transportName = null): ?MessageEvent
{
    return test()->getNotifierEvent($index, $transportName);
}

/**
 * @return MessageInterface[]
 */
function getNotifierMessages(?string $transportName = null): array
{
    return test()->getNotifierMessages($transportName);
}

function getNotifierMessage(int $index = 0, ?string $transportName = null): ?MessageInterface
{
    return test()->getNotifierMessage($index, $transportName);
}

function getNotifierNotificationEvents(): NotificationEvents
{
    return test()->getNotificationEvents();
}

function extend(Expectation $expect): void
{
    $expect->extend('toHaveNotificationCount', function (int $count, ?string $transport = null): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new NotifierConstraint\NotificationCount($count, $transport));

        return test();
    });

    $expect->extend('toHaveQueuedNotificationCount', function (int $count, ?string $transport = null): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new NotifierConstraint\NotificationCount($count, $transport, true));

        return test();
    });

    $expect->extend('toHaveNotificationIsQueued', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new NotifierConstraint\NotificationIsQueued());

        return test();
    });

    $expect->extend('toHaveNotificationSubjectContains', function (string $subject): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new NotifierConstraint\NotificationSubjectContains($subject));

        return test();
    });

    $expect->extend('toHaveNotificationTransportIsEqual', function (?string $transportName = null): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new NotifierConstraint\NotificationTransportIsEqual($transportName));

        return test();
    });
}
