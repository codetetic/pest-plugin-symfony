<?php

declare(strict_types=1);

namespace Pest\Symfony\Web\BrowserKit;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use Pest\Symfony\Constraint\Factory\BrowsertKit;
use Pest\Symfony\WebTestCase;
use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\BrowserKit\Test\Constraint as BrowserKitConstraint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Test\Constraint as ResponseConstraint;

function extend(Expectation $expect): void
{
    function unwrap(mixed $value, string $class): mixed
    {
        return match (true) {
            $value instanceof WebTestCase => match ($class) {
                Response::class => $value->getClientResponse(),
                Request::class => $value->getClientRequest(),
                KernelBrowser::class => $value->getClient(),
            },
            default => $value,
        };
    }

    $expect->extend('assertResponseIsSuccessful', function (): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toMatchConstraint(new ResponseConstraint\ResponseIsSuccessful());

        return test();
    });

    $expect->extend('assertResponseStatusCodeSame', function (int $expectedCode): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toMatchConstraint(new ResponseConstraint\ResponseStatusCodeSame($expectedCode));

        return test();
    });

    $expect->extend('assertResponseFormatSame', function (Request $request, ?string $expectedFormat): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toMatchConstraint(new ResponseConstraint\ResponseFormatSame($request, $expectedFormat));

        return test();
    });

    $expect->extend('assertResponseRedirects', function (Request $request, ?string $expectedLocation = null, ?int $expectedCode = null): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toMatchConstraint(BrowsertKit::createResponseRedirects($request, $expectedLocation, $expectedCode));

        return test();
    });

    $expect->extend('assertResponseHasHeader', function (string $headerName): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toMatchConstraint(new ResponseConstraint\ResponseHasHeader($headerName));

        return test();
    });

    $expect->extend('assertResponseHeaderSame', function (string $headerName, string $expectedValue): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toMatchConstraint(new ResponseConstraint\ResponseHeaderSame($headerName, $expectedValue));

        return test();
    });

    $expect->extend('assertResponseHasCookie', function (string $name, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toMatchConstraint(new ResponseConstraint\ResponseHasCookie($name, $path, $domain));

        return test();
    });

    $expect->extend('assertResponseCookieValueSame', function (string $name, string $expectedValue, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toMatchConstraint(new ResponseConstraint\ResponseCookieValueSame($name, $expectedValue, $path, $domain));

        return test();
    });

    $expect->extend('assertResponseIsUnprocessable', function (): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toMatchConstraint(new ResponseConstraint\ResponseIsUnprocessable());

        return test();
    });

    $expect->extend('assertBrowserHasCookie', function (string $name, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, KernelBrowser::class))
            ->toMatchConstraint(new BrowserKitConstraint\BrowserHasCookie($name, $path, $domain));

        return test();
    });

    $expect->extend('assertBrowserCookieValueSame', function (string $name, string $expectedValue, bool $raw = false, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, KernelBrowser::class))
            ->toMatchConstraint(new BrowserKitConstraint\BrowserCookieValueSame($name, $expectedValue, $raw, $path, $domain));

        return test();
    });

    $expect->extend('assertRequestAttributeValueSame', function (string $name, string $expectedValue): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Request::class))
            ->toMatchConstraint(new ResponseConstraint\RequestAttributeValueSame($name, $expectedValue));

        return test();
    });

    $expect->extend('assertRouteSame', function (string $expectedRoute, array $parameters = []): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Request::class))
            ->toMatchConstraint(BrowsertKit::createRouteSame($expectedRoute, $parameters));

        return test();
    });

    $expect->extend('assertThatForResponse', function (Constraint $constraint): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, Response::class))
            ->toMatchConstraint($constraint);

        return test();
    });

    $expect->extend('assertThatForClient', function (Constraint $constraint): HigherOrderTapProxy|TestCall {
        expect(unwrap($this->value, KernelBrowser::class))
            ->toMatchConstraint($constraint);

        return test();
    });
}
