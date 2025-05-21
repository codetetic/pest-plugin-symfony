<?php

use function Pest\Symfony\Web\createClient;

it('can assert ResponseIsSuccessful', function (): void {
    createClient()->request('GET', '/example');

    expect($this)->toBeResponseIsSuccessful();
});