<?php

declare(strict_types=1);

namespace Pest\Symfony\Kernel;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

function bootKernel(): KernelInterface
{
    return test()->bootKernel();
}

function getContainer(): ContainerInterface
{
    return test()->getContainer();
}
