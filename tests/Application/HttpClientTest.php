<?php

use function Pest\Symfony\Kernel\HttpClient\getHttpClientDataCollector;
use function Pest\Symfony\Web\createClient;

it('can assert HttpClientRequest', function (): void {
    /** @var Symfony\Bundle\FrameworkBundle\KernelBrowser $client */
    $client = createClient();
    $client->enableProfiler();
    $client->request('GET', '/http-client');

    $this->assertHttpClientRequest('https://symfony.com/');
    $this->assertHttpClientRequest('https://symfony.com/', httpClientId: 'symfony.http_client');
    $this->assertHttpClientRequest('https://symfony.com/', 'POST', 'foo', httpClientId: 'symfony.http_client');
    $this->assertHttpClientRequest('https://symfony.com/', 'POST', ['foo' => 'bar'], httpClientId: 'symfony.http_client');
    $this->assertHttpClientRequest('https://symfony.com/', 'POST', ['foo' => 'bar'], httpClientId: 'symfony.http_client');
    $this->assertHttpClientRequest('https://symfony.com/', 'POST', ['foo' => 'bar'], ['X-Test-Header' => 'foo'], 'symfony.http_client');
    $this->assertHttpClientRequest('https://symfony.com/doc/current/index.html', httpClientId: 'symfony.http_client');

    expect(getHttpClientDataCollector())->toHaveRequest('https://symfony.com/');
    expect(getHttpClientDataCollector())->toHaveRequest('https://symfony.com/', httpClientId: 'symfony.http_client');
    expect(getHttpClientDataCollector())->toHaveRequest('https://symfony.com/', 'POST', 'foo', httpClientId: 'symfony.http_client');
    expect(getHttpClientDataCollector())->toHaveRequest('https://symfony.com/', 'POST', ['foo' => 'bar'], httpClientId: 'symfony.http_client');
    expect(getHttpClientDataCollector())->toHaveRequest('https://symfony.com/', 'POST', ['foo' => 'bar'], httpClientId: 'symfony.http_client');
    expect(getHttpClientDataCollector())->toHaveRequest('https://symfony.com/', 'POST', ['foo' => 'bar'], ['X-Test-Header' => 'foo'], 'symfony.http_client');
    expect(getHttpClientDataCollector())->toHaveRequest('https://symfony.com/doc/current/index.html', httpClientId: 'symfony.http_client');
});

it('can assert HttpClientRequestCount', function (): void {
    /** @var Symfony\Bundle\FrameworkBundle\KernelBrowser $client */
    $client = createClient();
    $client->enableProfiler();
    $client->request('GET', '/http-client');

    $this->assertHttpClientRequestCount(1);
    expect(getHttpClientDataCollector())->toHaveRequestCount(1);

    $this->assertHttpClientRequestCount(6, 'symfony.http_client');
    expect(getHttpClientDataCollector())->toHaveRequestCount(6, 'symfony.http_client');
});
