<?php

use Symfony\Component\Mailer\Event\MessageEvent;
use Symfony\Component\Mime\RawMessage;

use function Pest\Symfony\Kernel\getContainer;
use function Pest\Symfony\Kernel\Mailer\getEvent;
use function Pest\Symfony\Kernel\Mailer\getEvents;
use function Pest\Symfony\Kernel\Mailer\getMessage;
use function Pest\Symfony\Kernel\Mailer\getMessageEvents;
use function Pest\Symfony\Kernel\Mailer\getMessages;

it('can get getEvents', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getEvents())
        ->toBeIterable();
});

it('can get getEvent', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getEvent())
        ->toBeInstanceOf(MessageEvent::class);
});

it('can get getMessages', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMessages())
        ->toBeIterable();
});

it('can get getMessage', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMessage())
        ->toBeInstanceOf(RawMessage::class);
});

it('can get getMessageEvents', function (): void {
    expect(getMessageEvents())
        ->toBeInstanceOf(Symfony\Component\Mailer\Event\MessageEvents::class);
});

it('can chain assert', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    expect(getMessageEvents())
        ->toHaveEmailCount(0, queued: false)
        ->toHaveEmailCount(1, queued: true);
});

it('can assert EmailCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertEmailCount(0);
    expect(getMessageEvents())
        ->toHaveEmailCount(0, queued: false);
});

it('can assert QueuedEmailCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertQueuedEmailCount(1);
    expect(getMessageEvents())
        ->toHaveEmailCount(1, queued: true);
});

it('can assert EmailIsQueued', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertEmailIsQueued(getEvent());
    expect(getEvent())
        ->toBeEmailQueued();
});

it('can assert EmailAttachmentCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertEmailAttachmentCount(getMessage(), 0);
    expect(getMessage())
        ->toHaveEmailAttachmentCount(0);
});

it('can assert EmailTextBodyContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertEmailTextBodyContains(getMessage(), 'text');
    expect(getMessage())
        ->toHaveEmailTextBody('text');
});

it('can assert EmailHtmlBodyContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertEmailHtmlBodyContains(getMessage(), '<p>html</p>');
    expect(getMessage())
        ->toHaveEmailHtmlBody('<p>html</p>');
});

it('can assert EmailHasHeader', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertEmailHasHeader(getMessage(), 'From');
    expect(getMessage())
        ->toHaveEmailHeader('From');
});

it('can assert EmailHeaderSame', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertEmailHeaderSame(getMessage(), 'From', 'from@example.com');
    expect(getMessage())
        ->toHaveEmailHeader('From', 'from@example.com');
});

it('can assert EmailAddressSame', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertEmailAddressContains(getMessage(), 'To', 'to@example.com');
    expect(getMessage())
        ->toHaveEmailAddress('To', 'to@example.com');
});

it('can assert EmailAddressContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertEmailAddressContains(getMessage(), 'To', 'to@example.com');
    expect(getMessage())
        ->toHaveEmailAddress('To', 'example.com', strict: false);
});

it('can assert EmailSubjectContains', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->email();

    $this->assertEmailSubjectContains(getMessage(), 'subject');
    expect(getMessage())
        ->toHaveEmailSubject('subject');
});
