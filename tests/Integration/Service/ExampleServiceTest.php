<?php

use function Pest\Symfony\getContainer;

it('can get and use service', function () {
    /** @var App\Service\ExampleService */
    $service = getContainer()->get(App\Service\ExampleService::class);

    expect($service->string())->toBe('string');
});