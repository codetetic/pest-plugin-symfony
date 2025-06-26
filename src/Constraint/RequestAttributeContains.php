<?php

declare(strict_types=1);

namespace Pest\Symfony\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\HttpFoundation\Request;

final class RequestAttributeContains extends Constraint
{
    public function __construct(private readonly string $name, private readonly string $value)
    {
    }

    public function toString(): string
    {
        return sprintf('has attribute "%s" with value "%s"', $this->name, $this->value);
    }

    /**
     * @param Request $request
     */
    protected function matches($request): bool
    {
        return str_contains((string) $request->attributes->get($this->name), $this->value);
    }

    /**
     * @param Request $request
     */
    protected function failureDescription($request): string
    {
        return 'the Request '.$this->toString();
    }
}
