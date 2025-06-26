<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\HttpFoundation\Response;

final class ResponseHeaderContains extends Constraint
{
    public function __construct(private readonly string $headerName, private readonly string $expectedValue)
    {
    }

    public function toString(): string
    {
        return sprintf('has header "%s" that contains the value "%s"', $this->headerName, $this->expectedValue);
    }

    /**
     * @param Response $response
     */
    protected function matches($response): bool
    {
        return str_contains((string) $response->headers->get($this->headerName, null), $this->expectedValue);
    }

    /**
     * @param Response $response
     */
    protected function failureDescription($response): string
    {
        return 'the Response '.$this->toString();
    }
}
