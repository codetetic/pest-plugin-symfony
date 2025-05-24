<?php

use function Pest\Symfony\DomCrawler\getCrawler;
use function Pest\Symfony\Web\createClient;

it('can get crawler', function (): void {
    createClient()->request('GET', '/example');

    expect(getCrawler())->toBeInstanceOf(Symfony\Component\DomCrawler\Crawler::class);
});

it('can assert SelectorExists', function (): void {
    createClient()->request('GET', '/html');

    expect(getCrawler())->assertSelectorExists('title');
});

it('can assert SelectorTextContains', function (): void {
    createClient()->request('GET', '/html');

    expect(getCrawler())->assertSelectorTextContains('title', 'Welcome!');
});
