<?php

use function Pest\Symfony\Kernel\getContainer;
use function Pest\Symfony\Kernel\Mailer\getMailerEvent;
use function Pest\Symfony\Kernel\Mailer\getMailerEvents;
use function Pest\Symfony\Kernel\Mailer\getMailerMessage;
use function Pest\Symfony\Kernel\Mailer\getMailerMessageEvents;
use function Pest\Symfony\Kernel\Mailer\getMailerMessages;

it('can get getMailerEvents', function (): void {
    expect(getMailerEvents())
        ->toBeIterable();
});

it('can get getMailerEvent', function (): void {
    expect(getMailerEvent())
        ->toBeNull();
});

it('can get getMailerMessages', function (): void {
    expect(getMailerMessages())
        ->toBeIterable();
});

it('can get getMailerMessage', function (): void {
    expect(getMailerMessage())
        ->toBeNull();
});

it('can get getMailerMessageEvents', function (): void {
    expect(getMailerMessageEvents())
        ->toBeInstanceOf(Symfony\Component\Mailer\Event\MessageEvents::class);
});

it('can chain assert', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessageEvents())
        ->assertEmailCount(0)
        ->assertQueuedEmailCount(1);
});

it('can assert EmailCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect($this)
        ->assertEmailCount(0);
    expect(getMailerMessageEvents())
        ->assertEmailCount(0);
});

it('can assert QueuedEmailCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect($this)
        ->assertQueuedEmailCount(1);
    expect(getMailerMessageEvents())
        ->assertQueuedEmailCount(1);
});

it('can assert EmailIsQueued', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerEvent())
        ->assertEmailIsQueued();
});

it('can assert EmailAttachmentCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->assertEmailAttachmentCount(0);
});

it('can assert EmailTextBodyContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->assertEmailTextBodyContains('text');
});

it('can assert EmailHtmlBodyContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->assertEmailHtmlBodyContains('html');
});

it('can assert EmailHasHeader', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->assertEmailHasHeader('From');
});

it('can assert EmailHeaderSame', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->assertEmailHeaderSame('From', 'from@example.com');
});

it('can assert EmailAddressContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->assertEmailAddressContains('To', 'to@example.com');
});

it('can assert EmailSubjectContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->assertEmailSubjectContains('subject');
});
