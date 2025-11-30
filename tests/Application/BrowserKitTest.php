<?php

use function Pest\Symfony\Web\createClient;
use function Pest\Symfony\Web\getClient;
use function Pest\Symfony\Web\getRequest;
use function Pest\Symfony\Web\getResponse;

it('can chain assert', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())
        ->toBeSuccessful()
        ->toHaveStatusCode(200);
});

it('can assert ResponseIsSuccessful', function (): void {
    createClient()->request('GET', '/example');

    $this->assertResponseIsSuccessful();
    expect(getResponse())->toBeSuccessful();
});

it('can assert ResponseIsUnprocessable', function (): void {
    createClient()->request('GET', '/unprocessable');

    $this->assertResponseIsUnprocessable();
    expect(getResponse())->toBeUnprocessable();
});

it('can assert ResponseStatusCodeSame', function (): void {
    createClient()->request('GET', '/example');

    $this->assertResponseStatusCodeSame(200);
    expect(getResponse())->toHaveStatusCode(200);
});

it('can assert ResponseFormatSame', function (): void {
    createClient()->request('GET', '/example');

    $this->assertResponseFormatSame('json');
    expect(getResponse())->toHaveFormat('json');
});

it('can assert ResponseRedirects', function (): void {
    createClient()->request('GET', '/redirect');

    $this->assertResponseRedirects('/redirected');
    expect(getResponse())->toHaveRedirect('/redirected');
});

it('can assert ResponseHasHeader', function (): void {
    createClient()->request('GET', '/example');

    $this->assertResponseHasHeader('Content-Type');
    expect(getResponse())->toHaveHeader('Content-Type');
});

it('can assert ResponseHeaderSame', function (): void {
    createClient()->request('GET', '/example');

    $this->assertResponseHeaderSame('Content-Type', 'application/json');
    expect(getResponse())->toHaveHeader('Content-Type', 'application/json');
});

it('can assert ResponseHeaderContains', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->toHaveHeader('Content-Type', 'application/', strict: false);
});

it('can assert ResponseHasCookie', function (): void {
    createClient()->request('GET', '/cookie');

    $this->assertResponseHasCookie('name');
    expect(getResponse())->toHaveCookie('name');
});

it('can assert ResponseCookieValueSame', function (): void {
    createClient()->request('GET', '/cookie');

    $this->assertResponseCookieValueSame('name', 'value');
    expect(getResponse())->toHaveCookie('name', 'value');
});

it('can assert ResponseCookieContains', function (): void {
    createClient()->request('GET', '/cookie');

    expect(getResponse())->toHaveCookie('name', 'val', strict: false);
});

it('can assert BrowserHasCookie', function (): void {
    createClient()->request('GET', '/cookie');

    $this->assertBrowserHasCookie('name');
    expect(getClient())->toHaveClientCookie('name');
});

it('can assert BrowserCookieValueSame', function (): void {
    createClient()->request('GET', '/cookie');

    $this->assertBrowserCookieValueSame('name', 'value');
    expect(getClient())->toHaveClientCookie('name', 'value');
});

it('can assert BrowserCookieContains', function (): void {
    createClient()->request('GET', '/cookie');

    expect(getClient())->toHaveClientCookie('name', 'val', strict: false);
});

it('can assert RequestAttributeValueSame', function (): void {
    createClient()->request('GET', '/example');

    $this->assertRequestAttributeValueSame('_route', 'app_example');
    expect(getRequest())->toHaveRequestAttribute('_route', 'app_example');
});

it('can assert RequestAttributeValueContains', function (): void {
    createClient()->request('GET', '/example');

    expect(getRequest())->toHaveRequestAttribute('_route', 'example', strict: false);
});

it('can assert RouteSame', function (): void {
    createClient()->request('GET', '/example');

    $this->assertRouteSame('app_example');
    expect(getRequest())->toHaveRequestRoute('app_example');
});

it('can assert RouteContains', function (): void {
    createClient()->request('GET', '/example');

    expect(getRequest())->toHaveRequestRoute('example', strict: false);
});
