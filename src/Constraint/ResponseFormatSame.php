<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ResponseFormatSame extends Constraint
{
    private Request $request;

    public function __construct(private ?string $format)
    {
        $this->request = new Request();
    }

    public function toString(): string
    {
        return 'format is '.($this->format ?? 'null');
    }

    /**
     * @param Response $response
     */
    protected function matches($response): bool
    {
        return $this->format === $this->request->getFormat($response->headers->get('Content-Type'));
    }

    /**
     * @param Response $response
     */
    protected function failureDescription($response): string
    {
        return 'the Response '.$this->toString();
    }

    /**
     * @param Response $response
     */
    protected function additionalFailureDescription($response): string
    {
        return (string) $response;
    }
}
