<?php

use function Pest\Symfony\Web\createClient;
use function Pest\Symfony\Web\getCrawler;

it('can get crawler', function (): void {
    createClient()->request('GET', '/example');

    expect(getCrawler())->toBeInstanceOf(Symfony\Component\DomCrawler\Crawler::class);
});

it('can assert SelectorExists', function (): void {
    createClient()->request('GET', '/html');

    $this->assertSelectorExists('title');
    expect(getCrawler())->toHaveSelector('title');
});

it('can assert SelectorTextContains', function (): void {
    createClient()->request('GET', '/html');

    $this->assertSelectorTextContains('title', 'Wel');
    expect(getCrawler())->toHaveSelector('title', 'Wel', strict: false);
});

it('can assert SelectorTextSame', function (): void {
    createClient()->request('GET', '/html');

    $this->assertSelectorTextSame('title', 'Welcome!');
    expect(getCrawler())->toHaveSelector('title', 'Welcome!');
});

it('can assert SelectorCount', function (): void {
    createClient()->request('GET', '/html');

    $this->assertSelectorCount(1, 'title');
    expect(getCrawler())->toHaveSelectorCount('title', 1);
});

it('can assert AnySelectorTextContains', function (): void {
    createClient()->request('GET', '/html');

    $this->assertAnySelectorTextContains('title', 'Welcome!');
    expect(getCrawler())->toHaveAnySelector('title', 'Welcome!');
});

it('can assert AnySelectorTextSame', function (): void {
    createClient()->request('GET', '/html');

    $this->assertAnySelectorTextSame('title', 'Welcome!');
    expect(getCrawler())->toHaveAnySelector('title', 'Welcome!');
});

it('can assert PageTitleContains', function (): void {
    createClient()->request('GET', '/html');

    $this->assertPageTitleContains('Wel');
    expect(getCrawler())->toHaveTitle('Wel', strict: false);
});

it('can assert PageTitleSame', function (): void {
    createClient()->request('GET', '/html');

    $this->assertPageTitleSame('Welcome!');
    expect(getCrawler())->toHaveTitle('Welcome!');
});

it('can assert InputValueSame', function (): void {
    createClient()->request('GET', '/html');

    $this->assertInputValueSame('text', 'value');
    expect(getCrawler())->toHaveInput('text', 'value');
});

it('can assert CheckboxChecked', function (): void {
    createClient()->request('GET', '/html');

    $this->assertCheckboxChecked('checkbox');
    expect(getCrawler())->toHaveCheckboxChecked('checkbox');
});

it('can assert FormValue', function (): void {
    createClient()->request('GET', '/html');

    $this->assertFormValue('form', 'text', 'value');
    expect(getCrawler())->toHaveFormInput('form', 'text', 'value');
});
