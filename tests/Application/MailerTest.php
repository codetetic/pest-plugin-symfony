<?php

use function Pest\Symfony\Kernel\getContainer;
use function Pest\Symfony\Mailer\getMailerEvent;
use function Pest\Symfony\Mailer\getMailerMessage;
use function Pest\Symfony\Mailer\getMessageMailerEvents;

it('can chain assert', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMessageMailerEvents())
        ->toBeEmailCount(0)
        ->toBeQueuedEmailCount(1);
});

it('can assert EmailCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMessageMailerEvents())
        ->toBeEmailCount(0);
});

it('can assert QueuedEmailCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMessageMailerEvents())
        ->toBeQueuedEmailCount(1);
});

it('can assert EmailIsQueued', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerEvent())
        ->toBeEmailIsQueued();
});

it('can assert EmailAttachmentCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toBeEmailAttachmentCount(0);
});

it('can assert EmailTextBodyContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toBeEmailTextBodyContains('text');
});

it('can assert EmailHtmlBodyContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toBeEmailHtmlBodyContains('html');
});

it('can assert EmailHasHeader', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toBeEmailHasHeader('From');
});

it('can assert EmailHeaderSame', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toBeEmailHeaderSame('From', 'from@example.com');
});

it('can assert EmailAddressContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toBeEmailAddressContains('To', 'to@example.com');
});

it('can assert EmailSubjectContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMailerMessage())
        ->toBeEmailSubjectContains('subject');
});