<?php

declare(strict_types=1);

namespace Pest\Symfony\Web\DomCrawler;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Pest\Symfony\Constraint\Factory\DomCrawler;
use Pest\Symfony\WebTestCase;
use Symfony\Component\DomCrawler\Test\Constraint as DomCrawlerConstraint;

function extend(Expectation $expect): void
{
    function unwrap(mixed $value): mixed
    {
        return match (true) {
            $value instanceof WebTestCase => $value->getClientCrawler(),
            default => $value,
        };
    }

    $expect->extend('assertSelectorExists', function (string $selector): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value))
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorExists($selector));

        return test();
    });

    $expect->extend('assertSelectorCount', function (int $expectedCount, string $selector): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value))
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorCount($expectedCount, $selector));

        return test();
    });

    $expect->extend('assertSelectorTextContains', function (string $selector, string $text): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value))
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorTextContains($selector, $text));

        return test();
    });

    $expect->extend('assertAnySelectorTextContains', function (string $selector, string $text): HigherOrderTapProxy|TestCall { // @phpstan-ignore-line
        expect(unwrap($this->value))
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerAnySelectorTextContains($selector, $text));

        return test();
    });

    $expect->extend('assertSelectorTextSame', function (string $selector, string $text): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value))
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorTextSame($selector, $text));

        return test();
    });

    $expect->extend('assertAnySelectorTextSame', function (string $selector, string $text): HigherOrderTapProxy|TestCall { // @phpstan-ignore-line
        expect(unwrap($this->value))
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerAnySelectorTextSame($selector, $text));

        return test();
    });

    $expect->extend('assertPageTitleSame', function (string $expectedTitle): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value))
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorTextSame('title', $expectedTitle));

        return test();
    });

    $expect->extend('assertPageTitleContains', function (string $expectedTitle): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value))
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorTextContains('title', $expectedTitle));

        return test();
    });

    $expect->extend('assertInputValueSame', function (string $selector, string $expectedValue): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value))
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorAttributeValueSame("input[name=\"$selector\"]", 'value', $expectedValue));

        return test();
    });

    $expect->extend('assertCheckboxChecked', function (string $fieldName): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value))
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorExists("input[name=\"$fieldName\"]:checked"));

        return test();
    });

    $expect->extend('assertFormValue', function (string $formSelector, string $fieldName, string $value): HigherOrderTapProxy|TestCall {

        return test();
    });
}
