<?php

declare(strict_types=1);

namespace Pest\Symfony\Web;

use Pest\Expectation;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

function extend(Expectation $expect): void
{
    BrowserKit\extend($expect);
    DomCrawler\extend($expect);
}

function createClient(array $options = [], array $server = []): AbstractBrowser
{
    return test()->createClient($options, $server);
}

function getClient(?AbstractBrowser $newClient = null): ?AbstractBrowser
{
    return test()->getClient(...func_get_args());
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
