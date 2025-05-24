<?php

declare(strict_types=1);

namespace Pest\Symfony\DomCrawler;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Test\Constraint as DomCrawlerConstraint;

function getCrawler(): ?Crawler
{
    return test()->getCrawler();
}

function extend(Expectation $expect): void
{
    function unwrap(mixed $value): mixed
    {
        return match (true) {
            $value instanceof WebTestCase => getCrawler(),
            default => $value,
        };
    }

    $expect->extend('assertSelectorExists', function (string $selector): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value))
            ->toBeInstanceOf(Crawler::class)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorExists($selector));

        return test();
    });

    $expect->extend('assertSelectorTextContains', function (string $selector, string $text): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value))
            ->toBeInstanceOf(Crawler::class)
            ->toMatchConstraint(new DomCrawlerConstraint\CrawlerSelectorTextContains($selector, $text));

        return test();
    });
}
