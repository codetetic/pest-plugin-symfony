<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\DomCrawler\Crawler;

final class DomCrawlerFormValueSame extends Constraint
{
    public function __construct(
        private readonly string $formSelector,
        private readonly string $fieldName,
        private readonly string $value,
    ) {
    }

    public function toString(): string
    {
        return sprintf('Field "%s" has a value in form "%s".', $this->fieldName, $this->formSelector);
    }

    protected function matches($crawler): bool
    {
        if (!($crawler instanceof Crawler)) {
            return false;
        }

        $node = $crawler->filter($this->formSelector);
        if (0 === count($node)) {
            return false;
        }

        $values = $node->form()->getValues();
        if (!array_key_exists($this->fieldName, $values)) {
            return false;
        }

        return $this->value === $values[$this->fieldName];
    }

    protected function failureDescription($crawler): string
    {
        return sprintf('Field "%s" has a value in form "%s".', $this->fieldName, $this->formSelector);
    }
}
