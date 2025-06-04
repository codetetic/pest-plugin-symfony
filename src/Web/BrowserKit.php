<?php

declare(strict_types=1);

namespace Pest\Symfony\Web\BrowserKit;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Pest\Symfony\Constraint\ResponseFormatSame;
use PHPUnit\Framework\Constraint\LogicalAnd;
use Symfony\Component\BrowserKit\Test\Constraint as BrowserKitConstraint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Test\Constraint as ResponseConstraint;
use function Pest\Symfony\Web\getRequest;

function extend(Expectation $expect): void
{
    $expect->extend('isSuccessful', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseIsSuccessful());

        return test();
    });

    $expect->extend('toHaveStatusCode', function (int $expectedCode): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseStatusCodeSame($expectedCode));

        return test();
    });

    $expect->extend('toHaveFormat', function (?string $expectedFormat): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseFormatSame($expectedFormat));

        return test();
    });

    $expect->extend('toHaveRedirect', function (?string $expectedLocation = null, ?int $expectedCode = null, Request $request = null): HigherOrderTapProxy|TestCall {
        $constraints = [
            new ResponseConstraint\ResponseIsRedirected(),
        ];
        if ($expectedLocation) {
            if ($request === null) {
                $request = getRequest();
            }
            $constraints[] = new ResponseConstraint\ResponseHeaderLocationSame($request, $expectedLocation);
        }
        if ($expectedCode) {
            $constraints[] = new ResponseConstraint\ResponseStatusCodeSame($expectedCode);
        }

        expect($this->value)
            ->toMatchConstraint(LogicalAnd::fromConstraints(...$constraints));

        return test();
    });

    $expect->extend('toHaveHeader', function (string $headerName, ?string $expectedValue = null): HigherOrderTapProxy|TestCall {
        $constraint = new ResponseConstraint\ResponseHasHeader($headerName);
        if (2 === func_num_args()) {
            $constraint = new ResponseConstraint\ResponseHeaderSame($headerName, $expectedValue);
        }

        expect($this->value)
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('toHaveCookie', function (string $name, ?string $expectedValue = null, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        $constraint = new ResponseConstraint\ResponseHasCookie($name, $path, $domain);
        if (2 === func_num_args()) {
            $constraint = new ResponseConstraint\ResponseCookieValueSame($name, $expectedValue, $path, $domain);
        }

        expect($this->value)
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('isUnprocessable', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseIsUnprocessable());

        return test();
    });

    $expect->extend('toHaveBrowserCookie', function (string $name, ?string $expectedValue = null, bool $raw = false, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        $contraint = new BrowserKitConstraint\BrowserHasCookie($name, $path, $domain);
        if (2 === func_num_args()) {
            $contraint = new BrowserKitConstraint\BrowserCookieValueSame($name, $expectedValue, $raw, $path, $domain);
        }

        expect($this->value)
            ->toMatchConstraint($contraint);

        return test();
    });

    $expect->extend('toHaveRequestAttribute', function (string $name, string $expectedValue): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\RequestAttributeValueSame($name, $expectedValue));

        return test();
    });

    $expect->extend('toHaveRoute', function (string $expectedRoute, array $parameters = []): HigherOrderTapProxy|TestCall {
        $constraints = [
            new ResponseConstraint\RequestAttributeValueSame('_route', $expectedRoute),
        ];
        foreach ($parameters as $key => $value) {
            $constraints[] = new ResponseConstraint\RequestAttributeValueSame($key, $value);
        }

        expect($this->value)
            ->toMatchConstraint(LogicalAnd::fromConstraints(...$constraints));

        return test();
    });
}
