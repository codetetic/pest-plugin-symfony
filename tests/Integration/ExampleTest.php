<?php

use function Pest\Symfony\Kernel\getContainer;

it('can get and use service', function (): void {
    expect(
        getContainer()
            ->get(App\Service\ExampleService::class)
            ->string('string')
    )->toBe('string');
});
