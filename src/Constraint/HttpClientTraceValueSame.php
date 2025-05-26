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

        $traces = $this->getTraces($collector);
        if (null === $traces) {
            return false;
        }

        foreach ($traces as $trace) {
            $actualUrl = $trace['url'] ?? null;
            if ($this->expectedUrl !== $actualUrl) {
                continue;
            }

            $actualMethod = $trace['method'] ?? null;
            if ($this->expectedMethod !== $actualMethod) {
                continue;
            }

            return true;
        }

        return false;
    }

    /**
     * @param HttpClientDataCollector $collector
     */
    protected function failureDescription($collector): string
    {
        return sprintf('The expected request has not been called: "%s" - "%s"', $this->expectedMethod, $this->expectedUrl);
    }
}
