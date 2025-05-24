<?php

use function Pest\Symfony\Kernel\getContainer;
use function Pest\Symfony\Kernel\Notifier\getNotifierEvent;
use function Pest\Symfony\Kernel\Notifier\getNotifierMessage;
use function Pest\Symfony\Kernel\Notifier\getNotifierNotificationEvents;

it('can assert NotifierCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect($this)
        ->assertNotificationCount(0);
    expect(getNotifierNotificationEvents())
        ->assertNotificationCount(0);
});

it('can assert QueuedNotifierCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect($this)
        ->assertQueuedNotificationCount(1);
    expect(getNotifierNotificationEvents())
        ->assertQueuedNotificationCount(1);
});

it('can assert NotifierIsQueued', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierEvent())
        ->assertNotificationIsQueued();
});

it('can assert NotifierSubjectContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierMessage())
        ->assertNotificationSubjectContains('subject');
});

it('can assert NotifierTransportIsEqual', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->sms();

    expect(getNotifierMessage())
        ->assertNotificationTransportIsEqual(null);
});
