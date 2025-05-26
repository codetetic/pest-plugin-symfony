<?php

namespace Pest\Symfony\Constraint\Factory;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\LogicalAnd;
use Symfony\Component\DomCrawler\Test\Constraint as DomCrawlerConstraint;

class DomCrawler
{
    public static function createAnySelectorTextContains(string $selector, string $text): Constraint
    {
        $constraints = [
            new DomCrawlerConstraint\CrawlerSelectorExists($selector),
            new DomCrawlerConstraint\CrawlerSelectorTextContains($selector, $text)
        ];

        return LogicalAnd::fromConstraints(...$constraints);
    }

    public static function createAnySelectorTextSame(string $selector, string $text): Constraint
    {
        $constraints = [
            new DomCrawlerConstraint\CrawlerSelectorExists($selector),
            new DomCrawlerConstraint\CrawlerSelectorTextSame($selector, $text)
        ];

        return LogicalAnd::fromConstraints(...$constraints);
    }

    // TODO: fix not version
    public static function createInputValueSame(string $fieldName, string $expectedValue): Constraint
    {
        $constraints = [
            new DomCrawlerConstraint\CrawlerSelectorExists("input[name=\"$fieldName\"]"),
            new DomCrawlerConstraint\CrawlerSelectorAttributeValueSame("input[name=\"$fieldName\"]", 'value', $expectedValue),
        ];

        return LogicalAnd::fromConstraints(...$constraints);
    }
}