<?php

declare(strict_types=1);

namespace Pest\Symfony\Kernel\HttpClient;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Pest\Symfony\Constraint\HttpClientTraceCount;
use Pest\Symfony\Constraint\HttpClientTraceValueSame;
use Symfony\Component\HttpClient\DataCollector\HttpClientDataCollector;

function getHttpClientDataCollector(): HttpClientDataCollector
{
    return test()->getHttpClientDataCollector();
}

function extend(Expectation $expect): void
{
    $expect->extend('toHaveHttpClientRequest', function (string $expectedUrl, string $expectedMethod = 'GET', string $httpClientId = 'http_client'): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new HttpClientTraceValueSame($expectedUrl, $expectedMethod, $httpClientId));

        return test();
    });

    $expect->extend('toHaveHttpClientRequestCount', function (int $count, string $httpClientId = 'http_client'): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new HttpClientTraceCount($count, $httpClientId));

        return test();
    });
}
