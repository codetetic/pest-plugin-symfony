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

    public function sendEmail()
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }
}
