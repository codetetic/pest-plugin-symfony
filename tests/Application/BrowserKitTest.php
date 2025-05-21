<?php

use Symfony\Component\BrowserKit\Test\Constraint as BrowserKitConstraint;
use Symfony\Component\HttpFoundation\Test\Constraint as ResponseConstraint;

use function Pest\Symfony\Web\createClient;

it('can assert ResponseIsSuccessful', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->toBeResponseIsSuccessful();
});

it('can assert ResponseStatusCodeSame', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->toBeResponseStatusCodeSame(200);
});

it('can assert ResponseFormatSame', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->toBeResponseFormatSame('json');
});

it('can assert ResponseRedirects', function (): void {
    createClient()->request('GET', '/redirect');

    expect($this)->toBeResponseRedirects('/redirected');
});

it('can assert ResponseHasHeader', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->toBeResponseHasHeader('Content-Type');
});

it('can assert ResponseHeaderSame', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->toBeResponseHeaderSame('Content-Type', 'application/json');
});

it('can assert ResponseHasCookie', function (): void {
    createClient()->request('GET', '/cookie');

    expect($this)->toBeResponseHasCookie('name');
});

it('can assert ResponseCookieValueSame', function (): void {
    createClient()->request('GET', '/cookie');

    expect($this)->toBeResponseCookieValueSame('name', 'value');
});

it('can assert ResponseIsUnprocessable', function (): void {
    createClient()->request('GET', '/unprocessable');

    expect($this)->toBeResponseIsUnprocessable();
});

it('can assert BrowserHasCookie', function (): void {
    createClient()->request('GET', '/cookie');

    expect($this)->toBeBrowserHasCookie('name');
});

it('can assert BrowserCookieValueSame', function (): void {
    createClient()->request('GET', '/cookie');

    expect($this)->toBeBrowserCookieValueSame('name', 'value');
});

it('can assert RequestAttributeValueSame', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->toBeRequestAttributeValueSame('_route', 'app_example');
});

it('can assert RouteSame', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->toBeRouteSame('app_example');
});

it('can assert ThatForResponse', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->toBeThatForResponse(new ResponseConstraint\ResponseIsSuccessful());
});

it('can assert ThatForClient', function (): void {
    createClient()->request('GET', '/cookie');

    expect($this)->toBeThatForClient(new BrowserKitConstraint\BrowserHasCookie('name'));
});
