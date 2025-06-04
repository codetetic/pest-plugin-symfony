<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\HttpClient\DataCollector\HttpClientDataCollector;

final class HttpClientTraceCount extends Constraint
{
    use HttpClientTraceTrait;

    public function __construct(
        private int $count,
        private string $httpClientId = 'http_client',
    ) {
    }

    public function toString(): string
    {
        return sprintf('the request "%s" has been called "%d" times', $this->httpClientId, $this->count);
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

        return count($traces) === $this->count;
    }

    /**
     * @param HttpClientDataCollector $collector
     */
    protected function failureDescription($collector): string
    {
        return sprintf('The expected request "%s" has not been called "%d" times', $this->httpClientId, $this->count);
    }
}
