<?php

use function Pest\Symfony\Kernel\getContainer;
use function Pest\Symfony\Kernel\Notification\getNotificationEvents;
use function Pest\Symfony\Kernel\Notification\getNotifierEvent;
use function Pest\Symfony\Kernel\Notification\getNotifierMessage;

it('can assert NotificationCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotificationEvents())
        ->assertNotificationCount(0);
});

it('can assert QueuedNotificationCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotificationEvents())
        ->assertQueuedNotificationCount(1);
});

it('can assert NotificationIsQueued', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierEvent())
        ->assertNotificationIsQueued();
});

it('can assert NotificationSubjectContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierMessage())
        ->assertNotificationSubjectContains('subject');
});

it('can assert NotificationTransportIsEqual', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierMessage())
        ->assertNotificationTransportIsEqual(null);
});
