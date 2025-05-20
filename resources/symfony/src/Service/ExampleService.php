<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(public: true)]
class ExampleService
{
    public function string(): string
    {
        return 'string';
    }
}