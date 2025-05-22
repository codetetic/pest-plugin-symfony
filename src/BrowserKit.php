<?php

declare(strict_types=1);

namespace Pest\Symfony\BrowserKit;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\LogicalAnd;
use Symfony\Component\BrowserKit\Test\Constraint as BrowserKitConstraint;
use Symfony\Component\HttpFoundation\Test\Constraint as ResponseConstraint;

use function Pest\Symfony\Web\getRequest;

function extend(Expectation $expect): void
{
    $expect->extend('toBeResponseIsSuccessful', function (): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new ResponseConstraint\ResponseIsSuccessful()
        );

        return test();
    });

    $expect->extend('toBeResponseStatusCodeSame', function (int $expectedCode): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new ResponseConstraint\ResponseStatusCodeSame($expectedCode)
        );

        return test();
    });

    $expect->extend('toBeResponseFormatSame', function (?string $expectedFormat): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new ResponseConstraint\ResponseFormatSame(getRequest(), $expectedFormat)
        );

        return test();
    });

    $expect->extend('toBeResponseRedirects', function (?string $expectedLocation = null, ?int $expectedCode = null): HigherOrderTapProxy|TestCall {
        $constraint = new ResponseConstraint\ResponseIsRedirected();
        if ($expectedLocation) {
            $constraint = LogicalAnd::fromConstraints(
                $constraint,
                new ResponseConstraint\ResponseHeaderLocationSame(getRequest(), $expectedLocation)
            );
        }
        if ($expectedCode) {
            $constraint = LogicalAnd::fromConstraints(
                $constraint,
                new ResponseConstraint\ResponseStatusCodeSame($expectedCode)
            );
        }

        test()->assertThat(
            $this->value,
            $constraint,
        );

        return test();
    });

    $expect->extend('toBeResponseHasHeader', function (string $headerName): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new ResponseConstraint\ResponseHasHeader($headerName),
        );

        return test();
    });

    $expect->extend('toBeResponseHeaderSame', function (string $headerName, string $expectedValue): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new ResponseConstraint\ResponseHeaderSame($headerName, $expectedValue),
        );

        return test();
    });

    $expect->extend('toBeResponseHasCookie', function (string $name, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new ResponseConstraint\ResponseHasCookie($name, $path, $domain)
        );

        return test();
    });

    $expect->extend('toBeResponseCookieValueSame', function (string $name, string $expectedValue, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            LogicalAnd::fromConstraints(
                new ResponseConstraint\ResponseHasCookie($name, $path, $domain),
                new ResponseConstraint\ResponseCookieValueSame($name, $expectedValue, $path, $domain)
            ),
        );

        return test();
    });

    $expect->extend('toBeResponseIsUnprocessable', function (): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new ResponseConstraint\ResponseIsUnprocessable(),
        );

        return test();
    });

    $expect->extend('toBeBrowserHasCookie', function (string $name, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new BrowserKitConstraint\BrowserHasCookie($name, $path, $domain)
        );

        return test();
    });

    $expect->extend('toBeBrowserCookieValueSame', function (string $name, string $expectedValue, bool $raw = false, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            LogicalAnd::fromConstraints(
                new BrowserKitConstraint\BrowserHasCookie($name, $path, $domain),
                new BrowserKitConstraint\BrowserCookieValueSame($name, $expectedValue, $raw, $path, $domain)
            ),
        );

        return test();
    });

    $expect->extend('toBeRequestAttributeValueSame', function (string $name, string $expectedValue): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            new ResponseConstraint\RequestAttributeValueSame($name, $expectedValue),
        );

        return test();
    });

    $expect->extend('toBeRouteSame', function (string $expectedRoute, array $parameters = []): HigherOrderTapProxy|TestCall {
        $constraints = [];
        foreach ($parameters as $key => $value) {
            $constraints[] = new ResponseConstraint\RequestAttributeValueSame($key, $value);
        }

        test()->assertThat(
            $this->value,
            LogicalAnd::fromConstraints(
                new ResponseConstraint\RequestAttributeValueSame('_route', $expectedRoute),
                ...$constraints
            ),
        );

        return test();
    });

    $expect->extend('toBeThatForResponse', function (Constraint $constraint): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            $constraint,
        );

        return test();
    });

    $expect->extend('toBeThatForClient', function (Constraint $constraint, string $message = ''): HigherOrderTapProxy|TestCall {
        test()->assertThat(
            $this->value,
            $constraint,
        );

        return test();
    });
}
