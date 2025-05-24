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
    return test()->getNotifierNotificationEvents();
}

function extend(Expectation $expect): void
{
    function unwrap(mixed $value, string $class): mixed
    {
        return match (true) {
            $value instanceof KernelTestCase => match ($class) {
                NotificationEvents::class.'[]' => getNotifierNotificationEvents(),
            },
            default => $value,
        };
    }

    $expect->extend('assertNotificationCount', function (int $count, ?string $transport = null): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, NotificationEvents::class.'[]'))
            ->toBeInstanceOf(NotificationEvents::class)
            ->toMatchConstraint(new NotifierConstraint\NotificationCount($count, $transport));

        return test();
    });

    $expect->extend('assertQueuedNotificationCount', function (int $count, ?string $transport = null): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, NotificationEvents::class.'[]'))
            ->toBeInstanceOf(NotificationEvents::class)
            ->toMatchConstraint(new NotifierConstraint\NotificationCount($count, $transport, true));

        return test();
    });

    $expect->extend('assertNotificationIsQueued', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toBeInstanceOf(MessageEvent::class)
            ->toMatchConstraint(new NotifierConstraint\NotificationIsQueued());

        return test();
    });

    $expect->extend('assertNotificationSubjectContains', function (string $subject): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toBeInstanceOf(MessageInterface::class)
            ->toMatchConstraint(new NotifierConstraint\NotificationSubjectContains($subject));

        return test();
    });

    $expect->extend('assertNotificationTransportIsEqual', function (?string $transportName = null): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toBeInstanceOf(MessageInterface::class)
            ->toMatchConstraint(new NotifierConstraint\NotificationTransportIsEqual($transportName));

        return test();
    });
}
