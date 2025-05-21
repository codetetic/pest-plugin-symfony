<?php

use function Pest\Symfony\Kernel\bootKernel;
use function Pest\Symfony\Kernel\getContainer;

it('can get and use service', function () {
    expect(bootKernel())->toBeInstanceOf(App\Kernel::class);

    /** @var App\Service\ExampleService */
    $service = getContainer()->get(App\Service\ExampleService::class);

    expect($service->string())->toBe('string');
});