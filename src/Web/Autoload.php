<?php

declare(strict_types=1);

namespace Pest\Symfony\Web;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

function createClient(): KernelBrowser
{
    return test()->createClient();
}

function getClient(): ?KernelBrowser
{
    return test()->getClient();
}

function getRequest(): Request
{
    return test()->getRequest();
}

function getResponse(): Response
{
    return test()->getResponse();
}

function getCrawler(): ?Crawler
{
    return test()->getCrawler();
}
