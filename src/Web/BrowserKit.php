<?php

declare(strict_types=1);

namespace Pest\Symfony\Web\BrowserKit;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Pest\Symfony\Constraint\Factory\BrowsertKit;
use PHPUnit\Framework\Constraint\LogicalAnd;
use Symfony\Component\BrowserKit\Test\Constraint as BrowserKitConstraint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Test\Constraint as ResponseConstraint;

function extend(Expectation $expect): void
{
    $expect->extend('toHaveResponseIsSuccessful', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseIsSuccessful());

        return test();
    });

    $expect->extend('toHaveResponseStatusCode', function (int $expectedCode): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseStatusCodeSame($expectedCode));

        return test();
    });

    $expect->extend('toHaveResponseFormat', function (Request $request, ?string $expectedFormat): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseFormatSame($request, $expectedFormat));

        return test();
    });

    $expect->extend('toHaveResponseRedirect', function (Request $request, ?string $expectedLocation = null, ?int $expectedCode = null): HigherOrderTapProxy|TestCall {
        $constraints = [
            new ResponseConstraint\ResponseIsRedirected(),
        ];
        if ($expectedLocation) {
            $constraints[] = new ResponseConstraint\ResponseHeaderLocationSame($request, $expectedLocation);
        }
        if ($expectedCode) {
            $constraints[] = new ResponseConstraint\ResponseStatusCodeSame($expectedCode);
        }

        expect($this->value)
            ->toMatchConstraint(LogicalAnd::fromConstraints(...$constraints));

        return test();
    });

    $expect->extend('toHaveResponseHeader', function (string $headerName, ?string $expectedValue = null): HigherOrderTapProxy|TestCall {
        $constraint = new ResponseConstraint\ResponseHasHeader($headerName);
        if (2 === func_num_args()) {
            $constraint = new ResponseConstraint\ResponseHeaderSame($headerName, $expectedValue);
        }

        expect($this->value)
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('toHaveResponseCookie', function (string $name, ?string $expectedValue = null, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        $constraint = new ResponseConstraint\ResponseHasCookie($name, $path, $domain);
        if (2 === func_num_args()) {
            $constraint = new ResponseConstraint\ResponseCookieValueSame($name, $expectedValue, $path, $domain);
        }

        expect($this->value)
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('toHaveResponseIsUnprocessable', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseIsUnprocessable());

        return test();
    });

    $expect->extend('toHaveBrowserCookie', function (string $name, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new BrowserKitConstraint\BrowserHasCookie($name, $path, $domain));

        return test();
    });

    $expect->extend('toHaveBrowserCookieValueSame', function (string $name, string $expectedValue, bool $raw = false, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new BrowserKitConstraint\BrowserCookieValueSame($name, $expectedValue, $raw, $path, $domain));

        return test();
    });

    $expect->extend('toHaveRequestAttributeValueSame', function (string $name, string $expectedValue): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\RequestAttributeValueSame($name, $expectedValue));

        return test();
    });

    $expect->extend('toHaveRouteSame', function (string $expectedRoute, array $parameters = []): HigherOrderTapProxy|TestCall {
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
