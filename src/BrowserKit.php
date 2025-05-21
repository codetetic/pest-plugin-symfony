<?php

declare(strict_types=1);

namespace Pest\Symfony\BrowserKit;

use Pest\Expectation;
use PHPUnit\Framework\Constraint\Constraint;

function extend(Expectation $expect): void {
    $expect->extend('toBeResponseIsSuccessful', function (): void {
        $this->assertResponseIsSuccessful();
    });

    $expect->extend('toBeResponseStatusCodeSame', function (int $expectedCode): void {
        $this->assertResponseStatusCodeSame($expectedCode);
    });

    $expect->extend('toBeResponseFormatSame', function (?string $expectedFormat): void {
        $this->assertResponseFormatSame($expectedFormat);
    });

    $expect->extend('toBeResponseRedirects', function (?string $expectedLocation = null, ?int $expectedCode = null): void {
        $this->assertResponseRedirects($expectedLocation, $expectedCode);
    });

    $expect->extend('toBeResponseHasHeader', function (string $headerName): void {
        $this->assertResponseHasHeader($headerName);
    });

    $expect->extend('toBeResponseHeaderSame', function (string $headerName, string $expectedValue): void {
        $this->assertResponseHeaderSame($headerName, $expectedValue);
    });

    $expect->extend('toBeResponseHasCookie', function (string $name, string $path = '/', ?string $domain = null): void {
        $this->assertResponseHasCookie($name, $path, $domain);
    });

    $expect->extend('toBeResponseCookieValueSame', function (string $name, string $expectedValue, string $path = '/', ?string $domain = null): void {
        $this->assertResponseCookieValueSame($name, $expectedValue, $path, $domain);
    });

    $expect->extend('toBeResponseIsUnprocessable', function (): void {
        $this->assertResponseIsUnprocessable();
    });

    $expect->extend('toBeBrowserHasCookie', function (string $name, string $path = '/', ?string $domain = null): void {
        $this->assertBrowserHasCookie($name, $path, $domain);
    });

    $expect->extend('toBeBrowserCookieValueSame', function (string $name, string $expectedValue, bool $raw = false, string $path = '/', ?string $domain = null): void {
        $this->assertBrowserCookieValueSame($name, $expectedValue, $raw, $path, $domain);
    });

    $expect->extend('toBeRequestAttributeValueSame', function (string $name, string $expectedValue): void {
        $this->assertRequestAttributeValueSame($name, $expectedValue);
    });

    $expect->extend('toBeRouteSame', function (string $route, array $parameters = []): void {
        $this->assertRouteSame($route, $parameters);
    });

    $expect->extend('toBeThatForResponse', function (Constraint $constraint, string $message = ''): void {
        $this->assertThatForResponse($constraint, $message);
    });

    $expect->extend('toBeThatForClient', function (Constraint $constraint, string $message = ''): void {
        $this->assertThatForClient($constraint, $message);
    });
}