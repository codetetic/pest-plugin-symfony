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
    $expect->extend('toBeSuccessful', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseIsSuccessful());

        return test();
    });

    $expect->extend('toHaveStatusCode', function (int $code): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseStatusCodeSame($code));

        return test();
    });

    $expect->extend('toHaveFormat', function (?string $format): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseFormatSame($format));

        return test();
    });

    $expect->extend('toHaveRedirect', function (?string $location = null, ?int $code = null, Request $request = null): HigherOrderTapProxy|TestCall {
        $constraints = [
            new ResponseConstraint\ResponseIsRedirected(),
        ];
        if ($location !== null) {
            if ($request === null) {
                $request = getRequest();
            }
            $constraints[] = new ResponseConstraint\ResponseHeaderLocationSame($request, $location);
        }
        if ($code !== null) {
            $constraints[] = new ResponseConstraint\ResponseStatusCodeSame($code);
        }

        expect($this->value)
            ->toMatchConstraint(LogicalAnd::fromConstraints(...$constraints));

        return test();
    });

    $expect->extend('toHaveHeader', function (string $key, ?string $value = null, bool $strict = true): HigherOrderTapProxy|TestCall {
        $constraint = match (true) {
            func_num_args() === 1  => new ResponseConstraint\ResponseHasHeader($key),
            func_get_args() > 1 && $strict === true => new ResponseConstraint\ResponseHeaderSame($key, $value),
        };

        expect($this->value)
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('toHaveCookie', function (string $key, ?string $value = null, string $path = '/', ?string $domain = null, bool $strict = true): HigherOrderTapProxy|TestCall {
        $constraint = match (true) {
            func_num_args() === 1 => new ResponseConstraint\ResponseHasCookie($key),
            func_get_args() > 1 && $strict === true => new ResponseConstraint\ResponseCookieValueSame($key, $value, $path, $domain),
        };

        expect($this->value)
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('toBeUnprocessable', function (): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\ResponseIsUnprocessable());

        return test();
    });

    $expect->extend('toHaveClientCookie', function (string $name, ?string $value = null, bool $raw = false, string $path = '/', ?string $domain = null, bool $strict = true): HigherOrderTapProxy|TestCall {
        $constraint = match (true) {
            func_num_args() === 1 => new BrowserKitConstraint\BrowserHasCookie($name, $path, $domain),
            func_get_args() > 1 && $strict === true => new BrowserKitConstraint\BrowserCookieValueSame($name, $value, $raw, $path, $domain),
        };

        expect($this->value)
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('toHaveRequestAttribute', function (string $name, string $value, bool $strict = true): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\RequestAttributeValueSame($name, $value));

        return test();
    });

    $expect->extend('toHaveRequestRoute', function (string $value, bool $strict = true): HigherOrderTapProxy|TestCall {
        expect($this->value)
            ->toMatchConstraint(new ResponseConstraint\RequestAttributeValueSame('_route', $value));

        return test();
    });
}
