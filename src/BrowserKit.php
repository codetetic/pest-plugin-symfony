<?php

declare(strict_types=1);

namespace Pest\Symfony\BrowserKit;

use Pest\Expectation;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;
use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

function extend(Expectation $expect): void
{
    function runner(WebTestCase $test, string $method, array $arguments = []): HigherOrderTapProxy|TestCall
    {
        call_user_func([$test, $method], ...$arguments);

        return test();
    }

    $expect->extend('toBeResponseIsSuccessful', function (): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertResponseIsSuccessful');
    });

    $expect->extend('toBeResponseStatusCodeSame', function (int $expectedCode): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertResponseStatusCodeSame', [$expectedCode]);
    });

    $expect->extend('toBeResponseFormatSame', function (?string $expectedFormat): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertResponseFormatSame', [$expectedFormat]);
    });

    $expect->extend('toBeResponseRedirects', function (?string $expectedLocation = null, ?int $expectedCode = null): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertResponseRedirects', [$expectedLocation, $expectedCode]);
    });

    $expect->extend('toBeResponseHasHeader', function (string $headerName): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertResponseHasHeader', [$headerName]);
    });

    $expect->extend('toBeResponseHeaderSame', function (string $headerName, string $expectedValue): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertResponseHeaderSame', [$headerName, $expectedValue]);
    });

    $expect->extend('toBeResponseHasCookie', function (string $name, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertResponseHasCookie', [$name, $path, $domain]);
    });

    $expect->extend('toBeResponseCookieValueSame', function (string $name, string $expectedValue, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertResponseCookieValueSame', [$name, $expectedValue, $path, $domain]);
    });

    $expect->extend('toBeResponseIsUnprocessable', function (): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertResponseIsUnprocessable');
    });

    $expect->extend('toBeBrowserHasCookie', function (string $name, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertBrowserHasCookie', [$name, $path, $domain]);
    });

    $expect->extend('toBeBrowserCookieValueSame', function (string $name, string $expectedValue, bool $raw = false, string $path = '/', ?string $domain = null): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertBrowserCookieValueSame', [$name, $expectedValue, $raw, $path, $domain]);
    });

    $expect->extend('toBeRequestAttributeValueSame', function (string $name, string $expectedValue): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertRequestAttributeValueSame', [$name, $expectedValue]);
    });

    $expect->extend('toBeRouteSame', function (string $route, array $parameters = []): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertRouteSame', [$route, $parameters]);
    });

    $expect->extend('toBeThatForResponse', function (Constraint $constraint): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertThatForResponse', [$constraint]);
    });

    $expect->extend('toBeThatForClient', function (Constraint $constraint, string $message = ''): HigherOrderTapProxy|TestCall {
        return runner($this->value, 'assertThatForClient', [$constraint]);
    });
}
