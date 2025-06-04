<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\HttpClient\DataCollector\HttpClientDataCollector;

final class HttpClientTraceValueSame extends Constraint
{
    use HttpClientTraceTrait;

    public function __construct(
        private string $expectedUrl,
        private string $expectedMethod = 'GET',
        private string|array|null $expectedBody = null,
        private array $expectedHeaders = [],
        private string $httpClientId = 'http_client',
    ) {
    }

    public function toString(): string
    {
        return sprintf('has request been called for "%s" - "%s"', $this->expectedMethod, $this->expectedUrl);
    }

    /**
     * @param HttpClientDataCollector $collector
     */
    protected function matches($collector): bool
    {
        if (!$collector instanceof HttpClientDataCollector) {
            return false;
        }

        $traces = $this->getTraces($collector, $this->httpClientId);
        if (null === $traces) {
            return false;
        }

        foreach ($traces as $trace) {
            $traceUrl = $trace['info']['url'] ?? $trace['url'] ?? null;
            if ($this->expectedUrl !== $traceUrl) {
                continue;
            }

            if ($this->expectedMethod !== $trace['method']) {
                continue;
            }

            if (null !== $this->expectedBody && $this->expectedBody !== $this->getBody($trace)) {
                continue;
            }

            if ($this->expectedHeaders && false === $this->headersMatch($trace)) {
                continue;
            }

            return true;
        }

        return false;
    }

    private function headersMatch(array $trace): bool
    {
        $toCheck = $this->expectedHeaders;
        $actualHeaders = $trace['options']['headers'] ?? [];

        foreach ($actualHeaders as $headerKey => $actualHeader) {
            if (false === array_key_exists($headerKey, $this->expectedHeaders)) {
                continue;
            }

            $header = $actualHeaders[$headerKey];
            if (is_object($header) && method_exists($header, 'getValue')) {
                $header = $header->getValue(true);
            }

            if ($this->expectedHeaders[$headerKey] !== $header) {
                continue;
            }

            unset($toCheck[$headerKey]);
        }

        return 0 === count($toCheck);
    }

    private function getBody(array $trace): string|array|null
    {
        if (null !== $trace['options']['body'] && null === $trace['options']['json']) {
            return \is_string($trace['options']['body']) ? $trace['options']['body'] : $trace['options']['body']->getValue(true);
        }

        if (null === $trace['options']['body'] && null !== $trace['options']['json']) {
            return $trace['options']['json']->getValue(true);
        }

        return null;
    }

    /**
     * @param HttpClientDataCollector $collector
     */
    protected function failureDescription($collector): string
    {
        return sprintf('The expected request has not been called: "%s" - "%s"', $this->expectedMethod, $this->expectedUrl);
    }
}
