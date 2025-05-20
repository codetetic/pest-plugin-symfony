<?php

it('can get a 200 response from /example', function () {
    createClient()->request('GET', '/example');

    expect($this)->toBeResponseIsSuccessful();

    $request = getRequest();

    expect($request->getMethod())->toBe('GET');
    expect($request->getPathInfo())->toBe('/example');

    $response = getResponse();

    expect($response->getStatusCode())->toBe(200);
    expect($response->getContent())->toMatchSnapshot();
});