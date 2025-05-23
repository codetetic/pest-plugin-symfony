<?php

declare(strict_types=1);

namespace Pest\Symfony\BrowserKit;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\LogicalAnd;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Test\Constraint as BrowserKitConstraint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Test\Constraint as ResponseConstraint;

use function Pest\Symfony\Web\getClient;
use function Pest\Symfony\Web\getRequest;
use function Pest\Symfony\Web\getResponse;

function extend(Expectation $expect): void
{
    function unwrap(mixed $value, string $class): mixed
    {
        return match (true) {
            $value instanceof WebTestCase => match ($class) {
                Response::class => getResponse(),
                Request::class => getRequest(),
                KernelBrowser::class => getClient(),
            },
            default => $value,
        };
    }

    $expect->extend('assertResponseIsSuccessful', function (): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toBeInstanceOf(Response::class)
            ->toMatchConstraint(new ResponseConstraint\ResponseIsSuccessful());

        return test();
    });

    $expect->extend('assertResponseStatusCodeSame', function (int $expectedCode): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toBeInstanceOf(Response::class)
            ->toMatchConstraint(new ResponseConstraint\ResponseStatusCodeSame($expectedCode));

        return test();
    });

    $expect->extend('assertResponseFormatSame', function (?string $expectedFormat): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toBeInstanceOf(Response::class)
            ->toMatchConstraint(new ResponseConstraint\ResponseFormatSame(getRequest(), $expectedFormat));

        return test();
    });

    $expect->extend('assertResponseRedirects', function (?string $expectedLocation = null, ?int $expectedCode = null): HigherOrderTapProxy|TestCall {
        $constraints = [
            new ResponseConstraint\ResponseIsRedirected(),
        ];
        if ($expectedLocation) {
            $constraints[] = new ResponseConstraint\ResponseHeaderLocationSame(getRequest(), $expectedLocation);
        }
        if ($expectedCode) {
            $constraints[] = new ResponseConstraint\ResponseStatusCodeSame($expectedCode);
        }

        expect(unwrap($this->value, Response::class))
            ->toBeInstanceOf(Response::class)
            ->toMatchConstraint(LogicalAnd::fromConstraints(...$constraints));

        return test();
    });

    $expect->extend('assertResponseHasHeader', function (string $headerName): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toBeInstanceOf(Response::class)
            ->toMatchConstraint(new ResponseConstraint\ResponseHasHeader($headerName));

        return test();
    });

    $expect->extend('assertResponseHeaderSame', function (string $headerName, string $expectedValue): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toBeInstanceOf(Response::class)
            ->toMatchConstraint(new ResponseConstraint\ResponseHeaderSame($headerName, $expectedValue));

        return test();
    });

    $expect->extend('assertResponseHasCookie', function (string $name, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toBeInstanceOf(Response::class)
            ->toMatchConstraint(new ResponseConstraint\ResponseHasCookie($name, $path, $domain));

        return test();
    });

    $expect->extend('assertResponseCookieValueSame', function (string $name, string $expectedValue, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        $constraints = [
            new ResponseConstraint\ResponseHasCookie($name, $path, $domain),
            new ResponseConstraint\ResponseCookieValueSame($name, $expectedValue, $path, $domain),
        ];

        expect(unwrap($this->value, Response::class))
            ->toBeInstanceOf(Response::class)
            ->toMatchConstraint(LogicalAnd::fromConstraints(...$constraints));

        return test();
    });

    $expect->extend('assertResponseIsUnprocessable', function (): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toBeInstanceOf(Response::class)
            ->toMatchConstraint(new ResponseConstraint\ResponseIsUnprocessable());

        return test();
    });

    $expect->extend('assertBrowserHasCookie', function (string $name, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, KernelBrowser::class))
            ->toBeInstanceOf(KernelBrowser::class)
            ->toMatchConstraint(new BrowserKitConstraint\BrowserHasCookie($name, $path, $domain));

        return test();
    });

    $expect->extend('assertBrowserCookieValueSame', function (string $name, string $expectedValue, bool $raw = false, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        $constraints = [
            new BrowserKitConstraint\BrowserHasCookie($name, $path, $domain),
            new BrowserKitConstraint\BrowserCookieValueSame($name, $expectedValue, $raw, $path, $domain),
        ];

        expect(unwrap($this->value, KernelBrowser::class))
            ->toBeInstanceOf(KernelBrowser::class)
            ->toMatchConstraint(LogicalAnd::fromConstraints(...$constraints));

        return test();
    });

    $expect->extend('assertRequestAttributeValueSame', function (string $name, string $expectedValue): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Request::class))
            ->toBeInstanceOf(Request::class)
            ->toMatchConstraint(new ResponseConstraint\RequestAttributeValueSame($name, $expectedValue));

        return test();
    });

    $expect->extend('assertRouteSame', function (string $expectedRoute, array $parameters = []): HigherOrderTapProxy|TestCall {
        $constraints = [
            new ResponseConstraint\RequestAttributeValueSame('_route', $expectedRoute),
        ];
        foreach ($parameters as $key => $value) {
            $constraints[] = new ResponseConstraint\RequestAttributeValueSame($key, $value);
        }

        expect(unwrap($this->value, Request::class))
            ->toBeInstanceOf(Request::class)
            ->toMatchConstraint(LogicalAnd::fromConstraints(...$constraints));

        return test();
    });

    $expect->extend('assertThatForResponse', function (Constraint $constraint): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toBeInstanceOf(Response::class)
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('assertThatForClient', function (Constraint $constraint): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, KernelBrowser::class))
            ->toBeInstanceOf(KernelBrowser::class)
            ->toMatchConstraint($constraint);

        return test();
    });
}
