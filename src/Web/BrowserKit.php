<?php

declare(strict_types=1);

namespace Pest\Symfony\Web\BrowserKit;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Pest\Symfony\Constraint;
use PHPUnit\Framework\Constraint\LogicalAnd;
use Symfony\Component\BrowserKit\Test\Constraint as BrowserKitConstraint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Test\Constraint as ResponseConstraint;

use function Pest\Symfony\Web\getRequest;

function extend(Expectation $expect): void
{
    $expect->extend('toBeSuccessful', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseIsSuccessful());

        return test();
    });

    $expect->extend('toBeUnprocessable', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseIsUnprocessable());

        return test();
    });

    $expect->extend('toHaveStatusCode', function (int $code): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseStatusCodeSame($code));

        return test();
    });

    $expect->extend('toHaveFormat', function (?string $format): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new Constraint\ResponseFormatSame($format));

        return test();
    });

    $expect->extend('toHaveRedirect', function (?string $location = null, ?int $code = null, ?Request $request = null): HigherOrderTapProxy|TestCall {
        $constraints = [
            new ResponseConstraint\ResponseIsRedirected(),
        ];
        if (null !== $location) {
            if (null === $request) {
                $request = getRequest();
            }
            $constraints[] = new ResponseConstraint\ResponseHeaderLocationSame($request, $location);
        }
        if (null !== $code) {
            $constraints[] = new ResponseConstraint\ResponseStatusCodeSame($code);
        }

        expect($this->value)
            ->toMatchConstraint(LogicalAnd::fromConstraints(...$constraints));

        return test();
    });

    $expect->extend('toHaveHeader', function (string $key, ?string $value = null, bool $strict = true): HigherOrderTapProxy|TestCall {
        $constraint = match (true) {
            1 === func_num_args() => new ResponseConstraint\ResponseHasHeader($key),
            func_get_args() > 1 && true === $strict => new ResponseConstraint\ResponseHeaderSame($key, $value),
            func_get_args() > 1 && false === $strict => new Constraint\ResponseHeaderContains($key, $value),
        };

        expect($this->value)
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('toHaveCookie', function (string $key, ?string $value = null, string $path = '/', ?string $domain = null, bool $strict = true): HigherOrderTapProxy|TestCall {
        $constraint = match (true) {
            1 === func_num_args() => new ResponseConstraint\ResponseHasCookie($key),
            func_get_args() > 1 && true === $strict => new ResponseConstraint\ResponseCookieValueSame($key, $value, $path, $domain),
            func_get_args() > 1 && false === $strict => new Constraint\ResponseCookieValueContains($key, $value, $path, $domain),
        };

        expect($this->value)
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('toHaveClientCookie', function (string $name, ?string $value = null, bool $raw = false, string $path = '/', ?string $domain = null, bool $strict = true): HigherOrderTapProxy|TestCall {
        $constraint = match (true) {
            1 === func_num_args() => new BrowserKitConstraint\BrowserHasCookie($name, $path, $domain),
            func_get_args() > 1 && true === $strict => new BrowserKitConstraint\BrowserCookieValueSame($name, $value, $raw, $path, $domain),
            func_get_args() > 1 && false === $strict => new Constraint\BrowserCookieValueContains($name, $value, $raw, $path, $domain),
        };

        expect($this->value)
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('toHaveRequestAttribute', function (string $name, string $value, bool $strict = true): HigherOrderTapProxy|TestCall {
        $constraint = match ($strict) {
            true => new ResponseConstraint\RequestAttributeValueSame($name, $value),
            // false =>
        };

        expect($this->value)
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('toHaveRequestRoute', function (string $value, bool $strict = true): HigherOrderTapProxy|TestCall {
        $constraint = match ($strict) {
            true => new ResponseConstraint\RequestAttributeValueSame('_route', $value),
            // false =>
        };

        expect($this->value)
            ->toMatchConstraint($constraint);

        return test();
    });
}
