<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\RawMessage;

final class EmailHtmlBodySame extends Constraint
{
    public function __construct(private readonly string $expectedText)
    {
    }

    public function toString(): string
    {
        return sprintf('is "%s"', $this->expectedText);
    }

    /**
     * @param RawMessage $message
     */
    protected function matches($message): bool
    {
        if (RawMessage::class === $message::class || Message::class === $message::class) {
            throw new \LogicException('Unable to test a message HTML body on a RawMessage or Message instance.');
        }

        return $message->getHtmlBody() === $this->expectedText;
    }

    /**
     * @param RawMessage $message
     */
    protected function failureDescription($message): string
    {
        return 'the Email HTML body '.$this->toString();
    }
}
