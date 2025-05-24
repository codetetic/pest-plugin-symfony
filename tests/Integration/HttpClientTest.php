<?php

use function Pest\Symfony\Kernel\getContainer;
use function Pest\Symfony\Kernel\HttpClient\getHttpClientDataCollector;

it('can assert HttpClientRequest', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->http();

    expect(getHttpClientDataCollector())->assertHttpClientRequest('https://www.google.com');
});

it('can assert HttpClientRequestCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->http();

    expect(getHttpClientDataCollector())->assertHttpClientRequestCount(1);
});
