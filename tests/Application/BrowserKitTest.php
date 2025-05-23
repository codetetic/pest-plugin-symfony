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
        ->assertResponseIsSuccessful()
        ->assertResponseStatusCodeSame(200)
        ->assertResponseFormatSame('json');
});

it('can assert ResponseIsSuccessful', function (): void {
    createClient()->request('GET', '/example');

    $this->assertResponseIsSuccessful();
    expect($this)->assertResponseIsSuccessful();
    expect(getResponse())->assertResponseIsSuccessful();
});

it('can assert ResponseStatusCodeSame', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->assertResponseStatusCodeSame(200);
});

it('can assert ResponseFormatSame', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->assertResponseFormatSame('json');
});

it('can assert ResponseRedirects', function (): void {
    createClient()->request('GET', '/redirect');

    expect(getResponse())->assertResponseRedirects('/redirected');
});

it('can assert ResponseHasHeader', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->assertResponseHasHeader('Content-Type');
});

it('can assert ResponseHeaderSame', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->assertResponseHeaderSame('Content-Type', 'application/json');
});

it('can assert ResponseHasCookie', function (): void {
    createClient()->request('GET', '/cookie');

    expect(getResponse())->assertResponseHasCookie('name');
});

it('can assert ResponseCookieValueSame', function (): void {
    createClient()->request('GET', '/cookie');

    expect(getResponse())->assertResponseCookieValueSame('name', 'value');
});

it('can assert ResponseIsUnprocessable', function (): void {
    createClient()->request('GET', '/unprocessable');

    expect(getResponse())->assertResponseIsUnprocessable();
});

it('can assert BrowserHasCookie', function (): void {
    createClient()->request('GET', '/cookie');

    expect(getClient())->assertBrowserHasCookie('name');
});

it('can assert BrowserCookieValueSame', function (): void {
    createClient()->request('GET', '/cookie');

    expect(getClient())->assertBrowserCookieValueSame('name', 'value');
});

it('can assert RequestAttributeValueSame', function (): void {
    createClient()->request('GET', '/example');

    expect(getRequest())->assertRequestAttributeValueSame('_route', 'app_example');
});

it('can assert RouteSame', function (): void {
    createClient()->request('GET', '/example');

    expect(getRequest())->assertRouteSame('app_example');
});

it('can assert ThatForResponse', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->assertThatForResponse(new ResponseConstraint\ResponseIsSuccessful());
});

it('can assert ThatForClient', function (): void {
    createClient()->request('GET', '/cookie');

    expect(getClient())->assertThatForClient(new BrowserKitConstraint\BrowserHasCookie('name'));
});
