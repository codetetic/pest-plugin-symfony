<?php

declare(strict_types=1);

namespace Pest\Symfony\Kernel\HttpClient;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Pest\Symfony\Constraint\HttpClientTraceCount;
use Pest\Symfony\Constraint\HttpClientTraceValueSame;
use Pest\Symfony\KernelTestCase;
use Symfony\Component\HttpClient\DataCollector\HttpClientDataCollector;

function getHttpClientDataCollector(): HttpClientDataCollector
{
    return test()->getHttpClientDataCollector();
}

function extend(Expectation $expect): void
{
    function unwrap(mixed $value): mixed
    {
        return match (true) {
            $value instanceof KernelTestCase => $value->getHttpClientDataCollector(),
            default => $value,
        };
    }

    $expect->extend('assertHttpClientRequest', function (string $expectedUrl, string $expectedMethod = 'GET', string $httpClientId = 'http_client'): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value))
            ->toMatchConstraint(new HttpClientTraceValueSame($expectedUrl, $expectedMethod, $httpClientId));

        return test();
    });

    $expect->extend('assertHttpClientRequestCount', function (int $count, string $httpClientId = 'http_client'): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value))
            ->toMatchConstraint(new HttpClientTraceCount($count, $httpClientId));

        return test();
    });
}
