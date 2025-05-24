<?php

declare(strict_types=1);

namespace Pest\Symfony\Web;

use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

function createClient(array $options = [], array $server = []): AbstractBrowser
{
    return test()->createClient(...func_get_args());
}

function getClient(?AbstractBrowser $newClient = null): ?AbstractBrowser
{
    return test()->getClient(...func_get_args());
}

function getRequest(): Request
{
    return test()->getClientRequest();
}

function getResponse(): Response
{
    return test()->getClientResponse();
}

function getCrawler(): ?Crawler
{
    return test()->getClientCrawler();
}
