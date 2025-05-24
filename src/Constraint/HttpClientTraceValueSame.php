<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\HttpClient\DataCollector\HttpClientDataCollector;

final class HttpClientTraceValueSame extends Constraint
{
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

        $traces = $collector->getClients();
        if (!isset($traces[$this->httpClientId])) {
            return false;
        }

        foreach ($traces as $trace) {
            $actualUrl = $trace['info']['url'] ?? $trace['url'] ?? null;
            if ($this->expectedUrl !== $actualUrl) {
                continue;
            }

            $actualMethod = $trace['method'] ?? null;
            if ($this->expectedMethod !== $actualMethod) {
                continue;
            }

            if ($this->expectedBody !== null) {
                $actualBody = $trace['options']['body'] ?? $trace['options']['json'] ?? null;
                $actualBody = \is_string($actualBody) ? $actualBody : $actualBody?->getValue(true);

                if ($this->expectedBody !== $actualBody) {
                    continue;
                }
            }

            if (count($this->expectedHeaders) > 0) {
                $actualHeaders = $trace['options']['headers'] ?? [];

                foreach ($this->expectedHeaders as $headerKey => $expectedHeader) {
                    if (!isset($actualHeaders[$headerKey]) || $expectedHeader !== $actualHeaders[$headerKey]->getValue(true)) {
                        continue 2;
                    }
                }
            }

            return true;
        }

        return false;
    }

    /**
     * @param HttpClientDataCollector $collector
     */
    protected function failureDescription($traces): string
    {
        return sprintf('The expected request has not been called: "%s" - "%s"', $this->expectedMethod, $this->expectedUrl);
    }
}
