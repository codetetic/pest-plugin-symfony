<?php

declare(strict_types=1);

namespace Pest\Symfony;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

expect()->extend('toBeResponseIsSuccessful', function (): void {
    $this->assertResponseIsSuccessful();
});

function createClient(): KernelBrowser
{
    return test()->createClient();
}

 function getRequest(): Request
{
    return test()->getRequest();
}

function getResponse(): Response
{
    return test()->getResponse();
}

function bootKernel(): KernelInterface
{
    return test()->bootKernel();
}

function getContainer(): ContainerInterface
{
    return test()->getContainer();
}
