<?php

use function Pest\Symfony\Kernel\HttpClient\getHttpClientDataCollector;
use function Pest\Symfony\Web\createClient;

it('can assert HttpClientRequest', function (): void {
    /** @var \Symfony\Bundle\FrameworkBundle\KernelBrowser $client */
    $client = createClient();
    $client->enableProfiler();
    $client->request('GET', '/http-client');

    $this->assertHttpClientRequest('https://symfony.com/');
    expect(getHttpClientDataCollector())->toHaveHttpClientRequest('https://symfony.com/');
});

it('can assert HttpClientRequestCount', function (): void {
    /** @var \Symfony\Bundle\FrameworkBundle\KernelBrowser $client */
    $client = createClient();
    $client->enableProfiler();
    $client->request('GET', '/http-client');

    $this->assertHttpClientRequestCount(1);
    expect(getHttpClientDataCollector())->toHaveHttpClientRequestCount(1);
});
