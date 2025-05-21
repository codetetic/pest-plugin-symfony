<?php

declare(strict_types=1);

namespace Pest\Symfony;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

function bootKernel(): KernelInterface
{
    return test()->bootKernel();
}

function getContainer(): ContainerInterface
{
    return test()->getContainer();
}
