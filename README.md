# Pest Symfony Plugin

This project is a Pest Symfony Plugin that enhances testing capabilities for Symfony applications using Pest.

## Prerequisites

- PHP 8.1 or higher
- PestPHP 2.36 or higher
- Symfony 6.4 or higher
- Composer

## Installation

Install the package via Composer:

```bash
composer require --dev codetetic/pest-plugin-symfony
```

## Usage

This plugin provides a set of functions to enhance the Pest testing framework for Symfony applications.

### Setup

```php
// Pest.php

uses(Symfony\Bundle\FrameworkBundle\Test\WebTestCase::class)->in('Application');
uses(Symfony\Bundle\FrameworkBundle\Test\KernelTestCase::class)->in('Integration');

Pest\Symfony\BrowserKit\extend(expect());
```

### Example Tests

Below are some example tests that demonstrate the features of this plugin:

#### Basic Application Example

```php
<?php

use function Pest\Symfony\Web\createClient;
use function Pest\Symfony\Web\getRequest;
use function Pest\Symfony\Web\getResponse;

it('can get a 200 response from /example', function (): void {
    createClient()->request('GET', '/example');

    expect(getResponse())->assertResponseIsSuccessful();
    expect(getRequest()->getMethod())->toBe('GET');
    expect(getResponse()->getContent())->toMatchSnapshot();
});
```

#### Basic Integration Example

```php
<?php

use function Pest\Symfony\Kernel\getContainer;

it('can get and use service', function (): void {
    expect(
        getContainer()
            ->get(App\Service\ExampleService::class)
            ->string('string')
    )->toBe('string');
});
```

## License

This project is licensed under the MIT License. See the LICENSE.md file for details.

## Contributing

Contributions are welcome! Please submit a pull request or create an issue for any bugs or feature requests.

## Contact

For any inquiries, please contact Peter Measham at github@codetetic.co.uk.