<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\DomCrawler\Crawler;

final class CrawlerSelectorAttributeValueContains extends Constraint
{
    public function __construct(
        private string $selector,
        private string $attribute,
        private string $expectedText,
    ) {
    }

    public function toString(): string
    {
        return \sprintf('has a node matching selector "%s" with attribute "%s" contains the value "%s"', $this->selector, $this->attribute, $this->expectedText);
    }

    /**
     * @param Crawler $crawler
     */
    protected function matches($crawler): bool
    {
        $crawler = $crawler->filter($this->selector);
        if (!\count($crawler)) {
            return false;
        }

        return str_contains($crawler->attr($this->attribute) ?? '', $this->expectedText);
    }

    /**
     * @param Crawler $crawler
     */
    protected function failureDescription($crawler): string
    {
        return 'the Crawler '.$this->toString();
    }
}
