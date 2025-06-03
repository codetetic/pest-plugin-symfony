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
    $expect->extend('toHaveSelectorExists', function (string $selector): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorExists($selector));

        return test();
    });

    $expect->extend('toHaveSelectorCount', function (int $expectedCount, string $selector): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorCount($expectedCount, $selector));

        return test();
    });

    $expect->extend('toHaveSelectorTextContains', function (string $selector, string $text): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorTextContains($selector, $text));

        return test();
    });

    $expect->extend('toHaveAnySelectorTextContains', function (string $selector, string $text): HigherOrderTapProxy|TestCall { // @phpstan-ignore-line
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerAnySelectorTextContains($selector, $text));

        return test();
    });

    $expect->extend('toHaveSelectorTextSame', function (string $selector, string $text): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorTextSame($selector, $text));

        return test();
    });

    $expect->extend('toHaveAnySelectorTextSame', function (string $selector, string $text): HigherOrderTapProxy|TestCall { // @phpstan-ignore-line
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerAnySelectorTextSame($selector, $text));

        return test();
    });

    $expect->extend('toHavePageTitleSame', function (string $expectedTitle): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorTextSame('title', $expectedTitle));

        return test();
    });

    $expect->extend('toHavePageTitleContains', function (string $expectedTitle): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorTextContains('title', $expectedTitle));

        return test();
    });

    $expect->extend('toHaveInputValueSame', function (string $selector, string $expectedValue): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorAttributeValueSame("input[name=\"$selector\"]", 'value', $expectedValue));

        return test();
    });

    $expect->extend('toHaveCheckboxChecked', function (string $fieldName): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorExists("input[name=\"$fieldName\"]:checked"));

        return test();
    });

    $expect->extend('toHaveFormValue', function (string $formSelector, string $fieldName, string $value): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new DomCrawlerFormValueSame($formSelector, $fieldName, $value));

        return test();
    });
}
