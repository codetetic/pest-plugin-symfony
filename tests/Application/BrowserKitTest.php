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
        ->assertResponseStatusCodeSame(200);
});

it('can assert ResponseIsSuccessful', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->assertResponseIsSuccessful();
    expect(getResponse())->assertResponseIsSuccessful();
});

it('can assert ResponseStatusCodeSame', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->assertResponseStatusCodeSame(200);
    expect(getResponse())->assertResponseStatusCodeSame(200);
});

it('can assert ResponseFormatSame', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->assertResponseFormatSame(getRequest(), 'json');
    expect(getResponse())->assertResponseFormatSame(getRequest(), 'json');
});

it('can assert ResponseRedirects', function (): void {
    createClient()->request('GET', '/redirect');

    expect($this)->assertResponseRedirects(getRequest(), '/redirected');
    expect(getResponse())->assertResponseRedirects(getRequest(), '/redirected');
});

it('can assert ResponseHasHeader', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->assertResponseHasHeader('Content-Type');
    expect(getResponse())->assertResponseHasHeader('Content-Type');
});

it('can assert ResponseHeaderSame', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->assertResponseHeaderSame('Content-Type', 'application/json');
    expect(getResponse())->assertResponseHeaderSame('Content-Type', 'application/json');
});

it('can assert ResponseHasCookie', function (): void {
    createClient()->request('GET', '/cookie');

    expect($this)->assertResponseHasCookie('name');
    expect(getResponse())->assertResponseHasCookie('name');
});

it('can assert ResponseCookieValueSame', function (): void {
    createClient()->request('GET', '/cookie');

    expect($this)->assertResponseCookieValueSame('name', 'value');
    expect(getResponse())->assertResponseCookieValueSame('name', 'value');
});

it('can assert ResponseIsUnprocessable', function (): void {
    createClient()->request('GET', '/unprocessable');

    expect($this)->assertResponseIsUnprocessable();
    expect(getResponse())->assertResponseIsUnprocessable();
});

it('can assert BrowserHasCookie', function (): void {
    createClient()->request('GET', '/cookie');

    expect($this)->assertBrowserHasCookie('name');
    expect(getClient())->assertBrowserHasCookie('name');
});

it('can assert BrowserCookieValueSame', function (): void {
    createClient()->request('GET', '/cookie');

    expect($this)->assertBrowserCookieValueSame('name', 'value');
    expect(getClient())->assertBrowserCookieValueSame('name', 'value');
});

it('can assert RequestAttributeValueSame', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->assertRequestAttributeValueSame('_route', 'app_example');
    expect(getRequest())->assertRequestAttributeValueSame('_route', 'app_example');
});

it('can assert RouteSame', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->assertRouteSame('app_example');
    expect(getRequest())->assertRouteSame('app_example');
});

it('can assert ThatForResponse', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->assertThatForResponse(new ResponseConstraint\ResponseIsSuccessful());
    expect(getResponse())->assertThatForResponse(new ResponseConstraint\ResponseIsSuccessful());
});

it('can assert ThatForClient', function (): void {
    createClient()->request('GET', '/cookie');

    expect($this)->assertThatForClient(new BrowserKitConstraint\BrowserHasCookie('name'));
    expect(getClient())->assertThatForClient(new BrowserKitConstraint\BrowserHasCookie('name'));
});
