<?php

use function Pest\Symfony\Web\createClient;
use function Pest\Symfony\Web\getRequest;
use function Pest\Symfony\Web\getResponse;

it('can get a 200 response from /example', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->toBeSuccessful();
    expect(getRequest()->getMethod())->toBe('GET');
    expect(getResponse()->getContent())->toMatchSnapshot();
});
