<?php

use function Pest\Symfony\Kernel\getContainer;
use function Pest\Symfony\Kernel\HttpClient\getHttpClientDataCollector;

it('can assert HttpClientRequest', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->http();

    $this->assertHttpClientRequest('https://www.google.com');
    expect(getHttpClientDataCollector())->toHaveHttpClientRequest('https://www.google.com');
})->skip();

it('can assert HttpClientRequestCount', function (): void {
    getContainer()->get(App\Service\ExampleService::class)->http();

    $this->assertHttpClientRequestCount(1);
    expect(getHttpClientDataCollector())->toHaveHttpClientRequestCount(1);
})->skip();
