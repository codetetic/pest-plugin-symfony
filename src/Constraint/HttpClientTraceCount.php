<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\HttpClient\DataCollector\HttpClientDataCollector;

final class HttpClientTraceCount extends Constraint
{
    public function __construct(
        private int $count,
        private string $httpClientId = 'http_client',
    ) {
    }

    public function toString(): string
    {
        return sprintf('has request been called "%i" times', $this->count);
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

        return count($traces[$this->httpClientId]) === $this->count;
    }

    /**
     * @param HttpClientDataCollector $collector
     */
    protected function failureDescription($traces): string
    {
        return sprintf('The expected request has not been called "%i" times', $this->count);
    }
}
