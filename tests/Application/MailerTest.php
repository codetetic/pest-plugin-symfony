<?php

use function Pest\Symfony\Mailer\getMailerEvent;
use function Pest\Symfony\Mailer\getMailerEvents;
use function Pest\Symfony\Mailer\getMailerMessage;
use function Pest\Symfony\Mailer\getMailerMessages;
use function Pest\Symfony\Mailer\getMessageMailerEvents;

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

it('can get getMessageMailerEvents', function (): void {
    expect(getMessageMailerEvents())
        ->toBeInstanceOf(Symfony\Component\Mailer\Event\MessageEvents::class);
});
