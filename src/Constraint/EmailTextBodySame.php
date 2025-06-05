<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\RawMessage;

final class EmailTextBodySame extends Constraint
{
    private string $expectedText;

    public function __construct(string $expectedText)
    {
        $this->expectedText = $expectedText;
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
            throw new \LogicException('Unable to test a message text body on a RawMessage or Message instance.');
        }

        return $message->getTextBody() === $this->expectedText;
    }

    /**
     * @param RawMessage $message
     */
    protected function failureDescription($message): string
    {
        return 'the Email text body '.$this->toString();
    }
}
