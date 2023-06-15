# This is my package openlaravel-test-generator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/wasinpwg/openlaravel-test-generator.svg?style=flat-square)](https://packagist.org/packages/wasinpwg/openlaravel-test-generator)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/plong-wasin/openlaravel-test-generator/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/plong-wasin/openlaravel-test-generator/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/plong-wasin/openlaravel-test-generator/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/plong-wasin/openlaravel-test-generator/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/wasinpwg/openlaravel-test-generator.svg?style=flat-square)](https://packagist.org/packages/wasinpwg/openlaravel-test-generator)

This Laravel package allows you to generate automated tests for your application using OpenAI, a powerful language model. With this package, you can quickly create test cases for your Laravel codebase, saving you time and effort in writing tests manually.

## Installation

You can install the package via composer:

```bash
composer require wasinpwg/openlaravel-test-generator --dev
```

Next publish the config file with:

```bash
php artisan vendor:publish --provider="OpenAI\Laravel\ServiceProvider"
php artisan vendor:publish --tag="openai-test-generator-config"
```

Set environment variable `OPENAI_API_KEY` in `.env` file.

```bash
OPENAI_API_KEY=sk-xxxxxx
```

## Usage

```bash
php artisan openlaravel:generate-test --class="App\Http\Controller\UserController" --class="App\Http\Controller\PostController"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Wasin Phungwigrai](https://github.com/Plong-Wasin)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
