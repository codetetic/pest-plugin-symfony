<?php

use Symfony\Component\Notifier\Event\MessageEvent;
use Symfony\Component\Notifier\Event\NotificationEvents;
use Symfony\Component\Notifier\Message\MessageInterface;

use function Pest\Symfony\Kernel\getContainer;
use function Pest\Symfony\Kernel\Notifier\getNotifierEvent;
use function Pest\Symfony\Kernel\Notifier\getNotifierEvents;
use function Pest\Symfony\Kernel\Notifier\getNotifierMessage;
use function Pest\Symfony\Kernel\Notifier\getNotifierMessages;
use function Pest\Symfony\Kernel\Notifier\getNotifierNotificationEvents;

it('can assert getNotifierEvents', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierEvents())
        ->toBeIterable();
});

it('can assert getNotifierEvent', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierEvent())
        ->toBeInstanceOf(MessageEvent::class);
});

it('can assert getNotifierMessages', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierMessages())
        ->toBeIterable();
});

it('can assert getNotifierMessage', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierMessage())
        ->toBeInstanceOf(MessageInterface::class);
});

it('can assert getNotifierNotificationEvents', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierNotificationEvents())
        ->toBeInstanceOf(NotificationEvents::class);
});

it('can assert NotifierCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    $this->assertNotificationCount(0);
    expect(getNotifierNotificationEvents())
        ->toHaveNotifierCount(0, queued: false);
});

it('can assert QueuedNotifierCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    $this->assertQueuedNotificationCount(1);
    expect(getNotifierNotificationEvents())
        ->toHaveNotifierCount(1, queued: true);
});

it('can assert NotifierIsQueued', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierEvent())
        ->toHaveNotifierIsQueued();
});

it('can assert NotifierSubjectContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierMessage())
        ->toHaveNotifierSubjectContains('subject');
});

it('can assert NotifierTransportIsEqual', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierMessage())
        ->toHaveNotifierTransportIsEqual(null);
});
