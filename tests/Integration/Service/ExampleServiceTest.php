<?php

use function Pest\Symfony\bootKernel;
use function Pest\Symfony\getContainer;

it('can get and use service', function () {
    bootKernel();

    $container = getContainer();

    $service = $container->get(App\Service\ExampleService::class);

    expect($service->string())->toBe('string');
});