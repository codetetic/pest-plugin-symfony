<?php

use function Pest\Symfony\Web\createClient;
use function Pest\Symfony\Web\getClient;
use function Pest\Symfony\Web\getCrawler;
use function Pest\Symfony\Web\getRequest;
use function Pest\Symfony\Web\getResponse;

it('can create a client', function (): void {
    expect(createClient())->toBeInstanceOf(Symfony\Bundle\FrameworkBundle\KernelBrowser::class);
});

it('can get a client', function (): void {
    createClient();

    expect(getClient())->toBeInstanceOf(Symfony\Bundle\FrameworkBundle\KernelBrowser::class);
});

it('can get crawler', function (): void {
    createClient()->request('GET', '/example');

    expect(getCrawler())->toBeInstanceOf(Symfony\Component\DomCrawler\Crawler::class);
});

it('can get request', function (): void {
    createClient()->request('GET', '/example');

    expect(getRequest())->toBeInstanceOf(Symfony\Component\HttpFoundation\Request::class);
});

it('can get response', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->toBeInstanceOf(Symfony\Component\HttpFoundation\Response::class);
});
