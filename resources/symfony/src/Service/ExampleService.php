<?php

namespace App\Service;

use App\Message\ExampleMessage;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Autoconfigure(public: true)]
class ExampleService
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly TexterInterface $texter,
        private readonly HttpClientInterface $client,
    ) {
    }

    public function string(): string
    {
        return 'string';
    }

    public function email(): void
    {
        $email = (new Email())
            ->from('from@example.com')
            ->to('to@example.com')
            ->subject('subject')
            ->text('text')
            ->html('<p>html</p>');

        $this->mailer->send($email);
    }

    public function sms(): void
    {
        $this->texter->send(
            new SmsMessage(
              '+1411111111',
                'subject',
                '+1422222222',
            ),
        );
    }

    public function http(): void
    {
        $this->client->request(
            'GET',
            'https://www.google.com'
        );
    }
}
