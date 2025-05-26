<?php

use function Pest\Symfony\Web\createClient;
use function Pest\Symfony\Web\getCrawler;

it('can get crawler', function (): void {
    createClient()->request('GET', '/example');

    expect(getCrawler())->toBeInstanceOf(Symfony\Component\DomCrawler\Crawler::class);
});

it('can assert SelectorExists', function (): void {
    createClient()->request('GET', '/html');

    expect($this)->assertSelectorExists('title');
    expect(getCrawler())->assertSelectorExists('title');
});

it('can assert SelectorCount', function (): void {
    createClient()->request('GET', '/html');

    expect($this)->assertSelectorCount(1, 'title');
    expect(getCrawler())->assertSelectorCount(1, 'title');
});

it('can assert SelectorTextContains', function (): void {
    createClient()->request('GET', '/html');

    expect($this)->assertSelectorTextContains('title', 'Welcome!');
    expect(getCrawler())->assertSelectorTextContains('title', 'Welcome!');
});

it('can assert AnySelectorTextContains', function (): void {
    createClient()->request('GET', '/html');

    expect($this)->assertAnySelectorTextContains('title', 'Welcome!');
    expect(getCrawler())->assertAnySelectorTextContains('title', 'Welcome!');
});

it('can assert SelectorTextSame', function (): void {
    createClient()->request('GET', '/html');

    expect($this)->assertSelectorTextSame('title', 'Welcome!');
    expect(getCrawler())->assertSelectorTextSame('title', 'Welcome!');
});

it('can assert AnySelectorTextSame', function (): void {
    createClient()->request('GET', '/html');

    expect($this)->assertAnySelectorTextSame('title', 'Welcome!');
    expect(getCrawler())->assertAnySelectorTextSame('title', 'Welcome!');
});

it('can assert PageTitleContains', function (): void {
    createClient()->request('GET', '/html');

    expect($this)->assertPageTitleContains('Welcome!');
    expect(getCrawler())->assertPageTitleContains('Welcome!');
});

it('can assert PageTitleSame', function (): void {
    createClient()->request('GET', '/html');

    expect($this)->assertPageTitleSame('Welcome!');
    expect(getCrawler())->assertPageTitleSame('Welcome!');
});

it('can assert InputValueSame', function (): void {
    createClient()->request('GET', '/html');

    expect($this)->assertInputValueSame('text', 'value');
    expect(getCrawler())->assertInputValueSame('text', 'value');
});

it('can assert CheckboxChecked', function (): void {
    createClient()->request('GET', '/html');

    expect($this)->assertCheckboxChecked('checkbox');
    expect(getCrawler())->assertCheckboxChecked('checkbox');
});

it('can assert FormValue', function (): void {
    createClient()->request('GET', '/html');

    expect($this)->assertFormValue('form', 'text', 'value');
    expect(getCrawler())->assertFormValue('form', 'text', 'value');
});