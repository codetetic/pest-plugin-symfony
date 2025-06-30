<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\Mime\Header\MailboxHeader;
use Symfony\Component\Mime\Header\MailboxListHeader;
use Symfony\Component\Mime\RawMessage;

final class EmailAddressesValueContains extends Constraint
{
    private string $headerName;
    private string $expectedValue;

    public function __construct(string $headerName, string $expectedValue)
    {
        $this->headerName = $headerName;
        $this->expectedValue = $expectedValue;
    }

    public function toString(): string
    {
        return sprintf('contains address "%s" with value "%s"', $this->headerName, $this->expectedValue);
    }

    /**
     * @param RawMessage $message
     */
    protected function matches($message): bool
    {
        if (RawMessage::class === $message::class) {
            throw new \LogicException('Unable to test a message address on a RawMessage instance.');
        }

        $header = $message->getHeaders()->get($this->headerName);
        if ($header instanceof MailboxHeader) {
            return str_contains($header->getAddress()->getAddress(), $this->expectedValue);
        } elseif ($header instanceof MailboxListHeader) {
            foreach ($header->getAddresses() as $address) {
                if (str_contains($address->getAddress(), $this->expectedValue)) {
                    return true;
                }
            }

            return false;
        }

        throw new \LogicException('Unable to test a message address on a non-address header.');
    }

    /**
     * @param RawMessage $message
     */
    protected function failureDescription($message): string
    {
        return sprintf('the Email %s (value is %s)', $this->toString(), $message->getHeaders()->get($this->headerName)->getBodyAsString());
    }
}
