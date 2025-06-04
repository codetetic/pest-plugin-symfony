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
    /** @var \Symfony\Bundle\FrameworkBundle\KernelBrowser $client */
    $client = test()->getClient();

    $profile = $client->getProfile();
    expect($profile)
        ->toBeInstanceOf(\Symfony\Component\HttpKernel\Profiler\Profile::class);

    /** @var HttpClientDataCollector $httpClientDataCollector */
    $httpClientDataCollector = $profile->getCollector('http_client');

    return $httpClientDataCollector;
}

function extend(Expectation $expect): void
{
    $expect->extend('toHaveRequest', function (string $expectedUrl, string $expectedMethod = 'GET', string|array|null $expectedBody = null, array $expectedHeaders = [], string $httpClientId = 'http_client'): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new HttpClientTraceValueSame($expectedUrl, $expectedMethod, $expectedBody, $expectedHeaders, $httpClientId));

        return test();
    });

    $expect->extend('toHaveRequestCount', function (int $count, string $httpClientId = 'http_client'): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new HttpClientTraceCount($count, $httpClientId));

        return test();
    });
}
