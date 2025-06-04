<?php

use Symfony\Component\Mailer\Event\MessageEvent;
use Symfony\Component\Mime\RawMessage;

use function Pest\Symfony\Kernel\getContainer;
use function Pest\Symfony\Kernel\Mailer\getMailerEvent;
use function Pest\Symfony\Kernel\Mailer\getMailerEvents;
use function Pest\Symfony\Kernel\Mailer\getMailerMessage;
use function Pest\Symfony\Kernel\Mailer\getMailerMessageEvents;
use function Pest\Symfony\Kernel\Mailer\getMailerMessages;

it('can get getMailerEvents', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerEvents())
        ->toBeIterable();
});

it('can get getMailerEvent', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerEvent())
        ->toBeInstanceOf(MessageEvent::class);
});

it('can get getMailerMessages', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessages())
        ->toBeIterable();
});

it('can get getMailerMessage', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toBeInstanceOf(RawMessage::class);
});

it('can get getMailerMessageEvents', function (): void {
    expect(getMailerMessageEvents())
        ->toBeInstanceOf(Symfony\Component\Mailer\Event\MessageEvents::class);
});

it('can chain assert', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessageEvents())
        ->toHaveEmailCount(0, queued: false)
        ->toHaveEmailCount(1, queued: true);
});

it('can assert EmailCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertEmailCount(0);
    expect(getMailerMessageEvents())
        ->toHaveEmailCount(0, queued: false);
});

it('can assert QueuedEmailCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertQueuedEmailCount(1);
    expect(getMailerMessageEvents())
        ->toHaveEmailCount(1, queued: true);
});

it('can assert EmailIsQueued', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerEvent())
        ->toHaveEmailIsQueued();
});

it('can assert EmailAttachmentCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toHaveEmailAttachmentCount(0);
});

it('can assert EmailTextBodyContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toHaveEmailTextBody('text');
});

it('can assert EmailHtmlBodyContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toHaveEmailHtmlBody('html');
});

it('can assert EmailHasHeader', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toHaveEmailHeader('From');
});

it('can assert EmailHeaderSame', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toHaveEmailHeader('From', 'from@example.com');
});

it('can assert EmailAddressContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toHaveEmailAddress('To', 'to@example.com');
});

it('can assert EmailSubjectContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toHaveEmailSubject('subject');
});
