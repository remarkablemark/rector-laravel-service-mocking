# rector-laravel-service-mocking

[![packagist](https://img.shields.io/packagist/v/remarkablemark/rector-laravel-service-mocking)](https://packagist.org/packages/remarkablemark/rector-laravel-service-mocking)
[![test](https://github.com/remarkablemark/rector-laravel-service-mocking/actions/workflows/test.yml/badge.svg)](https://github.com/remarkablemark/rector-laravel-service-mocking/actions/workflows/test.yml)

Rector to replace deprecated Laravel service mocking testing methods such as `expectsEvents`, `expectsJobs`, and `expectsNotifications`.

From [Laravel 10](https://laravel.com/docs/10.x/upgrade#service-mocking):

> The deprecated `MocksApplicationServices` trait has been removed from the framework. This trait provided testing methods such as `expectsEvents`, `expectsJobs`, and `expectsNotifications`.
>
> If your application uses these methods, we recommend you transition to `Event::fake`, `Bus::fake`, and `Notification::fake`, respectively. You can learn more about mocking via fakes in the corresponding documentation for the component you are attempting to fake.

## Requirements

PHP >=8.0

## Install

Install with [Composer](http://getcomposer.org/):

```sh
composer require --dev remarkablemark/rector-laravel-service-mocking
```

## Usage

Register rule in `rector.php`:

```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Remarkablemark\RectorLaravelServiceMocking\LaravelServiceMockingRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(LaravelServiceMockingRector::class);
};
```

## License

[MIT](LICENSE)
