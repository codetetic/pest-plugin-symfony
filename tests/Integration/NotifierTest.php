<?php

use Symfony\Component\Notifier\Event\MessageEvent;
use Symfony\Component\Notifier\Event\NotificationEvents;
use Symfony\Component\Notifier\Message\MessageInterface;

use function Pest\Symfony\Kernel\getContainer;
use function Pest\Symfony\Kernel\Notifier\getEvent;
use function Pest\Symfony\Kernel\Notifier\getEvents;
use function Pest\Symfony\Kernel\Notifier\getMessage;
use function Pest\Symfony\Kernel\Notifier\getMessages;
use function Pest\Symfony\Kernel\Notifier\getNotificationEvents;

// fix name
it('can assert getEvents', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getEvents())
        ->toBeIterable();
});

it('can assert getEvent', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getEvent())
        ->toBeInstanceOf(MessageEvent::class);
});

it('can assert getMessages', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getMessages())
        ->toBeIterable();
});

it('can assert getMessage', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getMessage())
        ->toBeInstanceOf(MessageInterface::class);
});

it('can assert getNotificationEvents', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotificationEvents())
        ->toBeInstanceOf(NotificationEvents::class);
});

it('can assert NotificationCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    $this->assertNotificationCount(0);
    expect(getNotificationEvents())
        ->toHaveNotificationCount(0, queued: false);
});

it('can assert QueuedNotificationCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    $this->assertQueuedNotificationCount(1);
    expect(getNotificationEvents())
        ->toHaveNotificationCount(1, queued: true);
});

it('can assert NotificationIsQueued', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    $this->assertNotificationIsQueued(getEvent());
    expect(getEvent())
        ->toBeNotificationQueued();
});

it('can assert NotificationSubjectSame', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getMessage())
        ->toHaveNotificationSubject('subject');
});

it('can assert NotificationSubjectContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    $this->assertNotificationSubjectContains(getMessage(), 'sub');
    expect(getMessage())
        ->toHaveNotificationSubject('sub', strict: false);
});

it('can assert NotificationTransportIsEqual', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    $this->assertNotificationTransportIsEqual(getMessage(), null);
    expect(getMessage())
        ->toHaveNotificationTransport(null);
});
