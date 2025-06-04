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

        $traces = $this->getTraces($collector);
        if (null === $traces) {
            return false;
        }

        $expectedRequestHasBeenFound = false;
        foreach ($traces as $trace) {
            if (($this->expectedUrl !== $trace['info']['url'] && $this->expectedUrl !== $trace['url'])
                || $this->expectedMethod !== $trace['method']
            ) {
                continue;
            }

            if (null !== $this->expectedBody) {
                dd($this->expectedBody);
                $actualBody = null;

                if (null !== $trace['options']['body'] && null === $trace['options']['json']) {
                    $actualBody = \is_string($trace['options']['body']) ? $trace['options']['body'] : $trace['options']['body']->getValue(true);
                }

                if (null === $trace['options']['body'] && null !== $trace['options']['json']) {
                    $actualBody = $trace['options']['json']->getValue(true);
                }

                if (!$actualBody) {
                    continue;
                }

                if ($this->expectedBody === $actualBody) {
                    $expectedRequestHasBeenFound = true;

                    if (!$this->expectedHeaders) {
                        break;
                    }
                }
            }

            if ($this->expectedHeaders) {
                $actualHeaders = $trace['options']['headers'] ?? [];

                foreach ($actualHeaders as $headerKey => $actualHeader) {
                    if (\array_key_exists($headerKey, $this->expectedHeaders)
                        && $this->expectedHeaders[$headerKey] === $actualHeader->getValue(true)
                    ) {
                        $expectedRequestHasBeenFound = true;
                        break 2;
                    }
                }
            }

            $expectedRequestHasBeenFound = true;
            break;
        }

        return $expectedRequestHasBeenFound;
    }

    /**
     * @param HttpClientDataCollector $collector
     */
    protected function failureDescription($collector): string
    {
        return sprintf('The expected request has not been called: "%s" - "%s"', $this->expectedMethod, $this->expectedUrl);
    }
}
