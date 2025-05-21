<?php

use function Pest\Symfony\Web\createClient;
use function Pest\Symfony\Web\getClient;
use function Pest\Symfony\Web\getCrawler;
use function Pest\Symfony\Web\getRequest;
use function Pest\Symfony\Web\getResponse;

it('can get a 200 response from /example', function () {
    createClient()->request('GET', '/example');

    expect($this)->toBeResponseIsSuccessful();
    expect($this)->toBeResponseStatusCodeSame(200);
    expect($this)->toBeResponseFormatSame('json');

    expect(getClient())->toBeInstanceOf(Symfony\Bundle\FrameworkBundle\KernelBrowser::class);
    expect(getCrawler())->toBeInstanceOf(Symfony\Component\DomCrawler\Crawler::class);

    $request = getRequest();

    expect($request->getMethod())->toBe('GET');
    expect($request->getPathInfo())->toBe('/example');

    $response = getResponse();

    expect($response->getStatusCode())->toBe(200);
    expect($response->getContent())->toMatchSnapshot();
});

it('can get a 302 response from /redirect', function () {
    createClient()->request('GET', '/redirect');

    expect($this)->toBeResponseStatusCodeSame(302);
    expect($this)->toBeResponseRedirects('/redirected');
    expect($this)->toBeResponseHasHeader('Location');
    expect($this)->toBeResponseHeaderSame('Location', '/redirected');
});

it('can get cookie from /cookie', function () {
    createClient()->request('GET', '/cookie');

    expect($this)->toBeResponseIsSuccessful();
    expect($this)->toBeBrowserHasCookie('name');
    expect($this)->toBeBrowserCookieValueSame('name', 'value');
});