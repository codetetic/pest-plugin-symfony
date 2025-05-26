<?php

namespace Pest\Symfony\Constraint\Factory;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\LogicalAnd;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Test\Constraint as ResponseConstraint;
use Symfony\Component\BrowserKit\Test\Constraint as BrowserKitConstraint;

class BrowsertKit
{
    public static function createResponseRedirects(Request $request, ?string $expectedLocation = null, ?int $expectedCode = null): Constraint
    {
        $constraints = [
            new ResponseConstraint\ResponseIsRedirected(),
        ];
        if ($expectedLocation) {
            $constraints[] = new ResponseConstraint\ResponseHeaderLocationSame($request, $expectedLocation);
        }
        if ($expectedCode) {
            $constraints[] = new ResponseConstraint\ResponseStatusCodeSame($expectedCode);
        }

        return LogicalAnd::fromConstraints(...$constraints);
    }

    public static function createResponseCookieValueSame(string $name, string $expectedValue, string $path = '/', ?string $domain = null): Constraint
    {
        $constraints = [
            new ResponseConstraint\ResponseHasCookie($name, $path, $domain),
            new ResponseConstraint\ResponseCookieValueSame($name, $expectedValue, $path, $domain),
        ];

        return LogicalAnd::fromConstraints(...$constraints);
    }

    public static function createBrowserCookieValueSame(string $name, string $expectedValue, bool $raw = false, string $path = '/', ?string $domain = null): Constraint
    {
        $constraints = [
            new BrowserKitConstraint\BrowserHasCookie($name, $path, $domain),
            new BrowserKitConstraint\BrowserCookieValueSame($name, $expectedValue, $raw, $path, $domain),
        ];

        return LogicalAnd::fromConstraints(...$constraints);
    }

    public static function createRouteSame(string $expectedRoute, array $parameters = []): Constraint
    {
        $constraints = [
            new ResponseConstraint\RequestAttributeValueSame('_route', $expectedRoute),
        ];
        foreach ($parameters as $key => $value) {
            $constraints[] = new ResponseConstraint\RequestAttributeValueSame($key, $value);
        }

        return LogicalAnd::fromConstraints(...$constraints);
    }
}