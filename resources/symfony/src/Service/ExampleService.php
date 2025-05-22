<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Autoconfigure(public: true)]
class ExampleService
{
    public function __construct(
        private readonly MailerInterface $mailer,
    ) {
    }

    public function string(): string
    {
        return 'string';
    }

    public function email()
    {
        $email = (new Email())
            ->from('from@example.com')
            ->to('to@example.com')
            ->subject('subject')
            ->text('text')
            ->html('<p>html</p>');

        $this->mailer->send($email);
    }
}
