<?php

declare(strict_types=1);

expect()->extend('toBeResponseIsSuccessful', function (): void {
    $this->assertResponseIsSuccessful();
});

expect()->extend('toBeResponseStatusCodeSame', function (int $expectedCode): void {
    $this->assertResponseStatusCodeSame($expectedCode);
});

expect()->extend('toBeResponseFormatSame', function (?string $expectedFormat): void {
    $this->assertResponseFormatSame($expectedFormat);
});