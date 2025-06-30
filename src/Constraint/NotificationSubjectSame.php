<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

final class NotificationSubjectSame extends Constraint
{
    private string $expectedText;

    public function __construct(string $expectedText)
    {
        $this->expectedText = $expectedText;
    }

    public function toString(): string
    {
        return sprintf('contains "%s"', $this->expectedText);
    }

    /**
     * @param \Symfony\Component\Notifier\Message\MessageInterface $message
     */
    protected function matches($message): bool
    {
        return $message->getSubject() === $this->expectedText;
    }

    /**
     * @param \Symfony\Component\Notifier\Message\MessageInterface $message
     */
    protected function failureDescription($message): string
    {
        return 'the Notification subject '.$this->toString();
    }
}
