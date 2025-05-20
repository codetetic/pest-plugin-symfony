<?php

it('can get and use service', function () {
    self::bootKernel();

    $container = static::getContainer();

    $service = $container->get(App\Service\ExampleService::class);

    expect($service->string())->toBe('string');
});