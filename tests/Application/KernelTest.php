<?php

use function Pest\Symfony\Kernel\bootKernel;
use function Pest\Symfony\Kernel\getContainer;

it('can boot kernel', function (): void {
    expect(bootKernel())
        ->toBeInstanceOf(Symfony\Component\HttpKernel\KernelInterface::class);
});

it('can get container', function (): void {
    expect(getContainer())
        ->toBeInstanceOf(Symfony\Component\DependencyInjection\ContainerInterface::class);
});
