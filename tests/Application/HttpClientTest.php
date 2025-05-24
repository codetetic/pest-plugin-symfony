<?php

use function Pest\Symfony\Kernel\HttpClient\getHttpClientDataCollector;

it('can assert HttpClientRequest', function (): void {
    expect(getHttpClientDataCollector())->assertHttpClientRequest('/example');
});
