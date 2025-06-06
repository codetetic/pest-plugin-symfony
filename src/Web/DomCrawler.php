<?php

declare(strict_types=1);

namespace Pest\Symfony\Web\DomCrawler;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Pest\Symfony\Constraint\DomCrawlerFormValueSame;
use Symfony\Component\DomCrawler\Test\Constraint as DomCrawlerConstraint;

function extend(Expectation $expect): void
{
    $expect->extend('toHaveSelector', function (string $selector, string $text = null, bool $strict = false): HigherOrderTapProxy|TestCall {
        $contraint = match (true) {
            1 === func_num_args() => new DomCrawlerConstraint\CrawlerSelectorExists($selector),
            false === $strict => new DomCrawlerConstraint\CrawlerSelectorTextContains($selector, $text),
            true === $strict => new DomCrawlerConstraint\CrawlerSelectorTextSame($selector, $text),
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

    $expect->extend('toHaveAnySelector', function (string $selector, string $text, bool $strict = false): HigherOrderTapProxy|TestCall {
        $contraint = match ($strict) {
            false => new DomCrawlerConstraint\CrawlerAnySelectorTextSame($selector, $text),
            true => new DomCrawlerConstraint\CrawlerAnySelectorTextContains($selector, $text),
        };

        expect($this->value)
            ->toMatchConstraint($contraint);

        return test();
    });

    $expect->extend('toHaveTitle', function (string $expectedTitle, bool $strict = false): HigherOrderTapProxy|TestCall {
        $contraint = match ($strict) {
            false => new DomCrawlerConstraint\CrawlerSelectorTextContains('title', $expectedTitle),
            true => new DomCrawlerConstraint\CrawlerSelectorTextSame('title', $expectedTitle),
        };

        expect($this->value)
            ->toMatchConstraint($contraint);

        return test();
    });

    $expect->extend('toHaveInput', function (string $selector, string $expectedValue, bool $strict = false): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorAttributeValueSame("input[name=\"$selector\"]", 'value', $expectedValue));

        return test();
    });

    $expect->extend('toHaveCheckboxChecked', function (string $fieldName): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorExists("input[name=\"$fieldName\"]:checked"));

        return test();
    });

    $expect->extend('toHaveFormInput', function (string $formSelector, string $fieldName, string $value, bool $strict = false): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerFormValueSame($formSelector, $fieldName, $value));

        return test();
    });
}
