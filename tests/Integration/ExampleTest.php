<?php

use function Pest\Symfony\Kernel\bootKernel;
use function Pest\Symfony\Kernel\getContainer;
use function Pest\Symfony\Mailer\getMailerEvents;

it('can get and use service', function (): void {
    expect(bootKernel())->toBeInstanceOf(App\Kernel::class);

    /** @var App\Service\ExampleService */
    $service = getContainer()->get(App\Service\ExampleService::class);

    expect($service->string())->toBe('string');
});

it('can send email', function (): void {
    expect(bootKernel())->toBeInstanceOf(App\Kernel::class);

    /** @var App\Service\ExampleService */
    $service = getContainer()->get(App\Service\ExampleService::class);

    $service->sendEmail();

    expect(getMailerEvents())->toHaveCount(1);
});