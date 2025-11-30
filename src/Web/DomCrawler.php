<?php

declare(strict_types=1);

namespace Pest\Symfony\Web\DomCrawler;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Pest\Symfony\Constraint\CrawlerSelectorAttributeValueContains;
use Pest\Symfony\Constraint\DomCrawlerFormValueContains;
use Pest\Symfony\Constraint\DomCrawlerFormValueSame;
use Symfony\Component\DomCrawler\Test\Constraint as DomCrawlerConstraint;

function extend(Expectation $expect): void
{
    $expect->extend('toHaveSelector', function (string $selector, ?string $text = null, bool $strict = true): HigherOrderTapProxy|TestCall {
        $contraint = match (func_num_args()) {
            1 => new DomCrawlerConstraint\CrawlerSelectorExists($selector),
            2, 3 => match ($strict) {
                false => new DomCrawlerConstraint\CrawlerSelectorTextContains($selector, $text),
                true => new DomCrawlerConstraint\CrawlerSelectorTextSame($selector, $text),
            },
        };

        expect($this->value)
            ->toMatchConstraint($contraint);

        return test();
    });

    $expect->extend('toHaveSelectorCount', function (string $selector, int $count): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorCount($count, $selector));

        return test();
    });

    $expect->extend('toHaveAnySelector', function (string $selector, string $text, bool $strict = true): HigherOrderTapProxy|TestCall {
        $contraint = match ($strict) {
            true => new DomCrawlerConstraint\CrawlerAnySelectorTextContains($selector, $text),
            false => new DomCrawlerConstraint\CrawlerAnySelectorTextSame($selector, $text),
        };

        expect($this->value)
            ->toMatchConstraint($contraint);

        return test();
    });

    $expect->extend('toHaveTitle', function (string $value, bool $strict = true): HigherOrderTapProxy|TestCall {
        $contraint = match ($strict) {
            true => new DomCrawlerConstraint\CrawlerSelectorTextSame('title', $value),
            false => new DomCrawlerConstraint\CrawlerSelectorTextContains('title', $value),
        };

        expect($this->value)
            ->toMatchConstraint($contraint);

        return test();
    });

    $expect->extend('toHaveInput', function (string $selector, string $value, bool $strict = true): HigherOrderTapProxy|TestCall {
        $contraint = match ($strict) {
            true => new DomCrawlerConstraint\CrawlerSelectorAttributeValueSame("input[name=\"$selector\"]", 'value', $value),
            false => new CrawlerSelectorAttributeValueContains("input[name=\"$selector\"]", 'value', $value),
        };

        expect($this->value)
            ->toMatchConstraint($contraint);

        return test();
    });

    $expect->extend('toHaveCheckboxChecked', function (string $fieldName): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorExists("input[name=\"$fieldName\"]:checked"));

        return test();
    });

    $expect->extend('toHaveFormInput', function (string $selector, string $key, string $value, bool $strict = true): HigherOrderTapProxy|TestCall {
        $contraint = match ($strict) {
            true => new DomCrawlerFormValueSame($selector, $key, $value),
            false => new DomCrawlerFormValueContains($selector, $key, $value),
        };

        expect($this->value)
            ->toMatchConstraint($contraint);

        return test();
    });
}
