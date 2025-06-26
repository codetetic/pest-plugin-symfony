<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\Mime\Header\UnstructuredHeader;
use Symfony\Component\Mime\RawMessage;

final class EmailHeaderContains extends Constraint
{
    public function __construct(private readonly string $headerName, private readonly string $expectedValue)
    {
    }

    public function toString(): string
    {
        return sprintf('has header "%s" with value "%s"', $this->headerName, $this->expectedValue);
    }

    /**
     * @param RawMessage $message
     */
    protected function matches($message): bool
    {
        if (RawMessage::class === $message::class) {
            throw new \LogicException('Unable to test a message header on a RawMessage instance.');
        }

        return str_contains((string) $this->getHeaderValue($message), $this->expectedValue);
    }

    /**
     * @param RawMessage $message
     */
    protected function failureDescription($message): string
    {
        return sprintf('the Email %s (value is %s)', $this->toString(), $this->getHeaderValue($message) ?? 'null');
    }

    private function getHeaderValue($message): ?string
    {
        if (null === $header = $message->getHeaders()->get($this->headerName)) {
            return null;
        }

        return $header instanceof UnstructuredHeader ? $header->getValue() : $header->getBodyAsString();
    }
}
