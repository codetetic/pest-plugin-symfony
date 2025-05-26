<?php

declare(strict_types=1);

namespace Pest\Symfony\Kernel;

use Pest\Expectation;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

function extend(Expectation $expect): void
{
    Mailer\extend($expect);
    Notifier\extend($expect);
    HttpClient\extend($expect);
}

function bootKernel(): KernelInterface
{
    return test()->bootKernel();
}

function getContainer(): ContainerInterface
{
    return test()->getContainer();
}

