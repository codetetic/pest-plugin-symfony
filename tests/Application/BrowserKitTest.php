<?php

use Symfony\Component\BrowserKit\Test\Constraint as BrowserKitConstraint;
use Symfony\Component\HttpFoundation\Test\Constraint as ResponseConstraint;

use function Pest\Symfony\Web\createClient;
use function Pest\Symfony\Web\getClient;
use function Pest\Symfony\Web\getRequest;
use function Pest\Symfony\Web\getResponse;

it('can chain assert', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())
        ->toBeResponseIsSuccessful()
        ->toBeResponseStatusCodeSame(200)
        ->toBeResponseFormatSame('json');
});

it('can assert ResponseIsSuccessful', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->toBeResponseIsSuccessful();
});

it('can assert ResponseStatusCodeSame', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->toBeResponseStatusCodeSame(200);
});

it('can assert ResponseFormatSame', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->toBeResponseFormatSame('json');
});

it('can assert ResponseRedirects', function (): void {
    createClient()->request('GET', '/redirect');

    expect(getResponse())->toBeResponseRedirects('/redirected');
});

it('can assert ResponseHasHeader', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->toBeResponseHasHeader('Content-Type');
});

it('can assert ResponseHeaderSame', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->toBeResponseHeaderSame('Content-Type', 'application/json');
});

it('can assert ResponseHasCookie', function (): void {
    createClient()->request('GET', '/cookie');

    expect(getResponse())->toBeResponseHasCookie('name');
});

it('can assert ResponseCookieValueSame', function (): void {
    createClient()->request('GET', '/cookie');

    expect(getResponse())->toBeResponseCookieValueSame('name', 'value');
});

it('can assert ResponseIsUnprocessable', function (): void {
    createClient()->request('GET', '/unprocessable');

    expect(getResponse())->toBeResponseIsUnprocessable();
});

it('can assert BrowserHasCookie', function (): void {
    createClient()->request('GET', '/cookie');

    expect(getClient())->toBeBrowserHasCookie('name');
});

it('can assert BrowserCookieValueSame', function (): void {
    createClient()->request('GET', '/cookie');

    expect(getClient())->toBeBrowserCookieValueSame('name', 'value');
});

it('can assert RequestAttributeValueSame', function (): void {
    createClient()->request('GET', '/example');

    expect(getRequest())->toBeRequestAttributeValueSame('_route', 'app_example');
});

it('can assert RouteSame', function (): void {
    createClient()->request('GET', '/example');

    expect(getRequest())->toBeRouteSame('app_example');
});

it('can assert ThatForResponse', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->toBeThatForResponse(new ResponseConstraint\ResponseIsSuccessful());
});

it('can assert ThatForClient', function (): void {
    createClient()->request('GET', '/cookie');

    expect(getClient())->toBeThatForClient(new BrowserKitConstraint\BrowserHasCookie('name'));
});
