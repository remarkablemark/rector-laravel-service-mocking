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

Run inside of tests only:

```php
$rectorConfig->paths([
    __DIR__ . '/tests',
]);
```

See the diff:

```php
vendor/bin/rector process src --dry-run
```

Apply the rule:

```php
vendor/bin/rector process src
```

## Rule

### Before

```php
$this->expectsEvents([MyEvent::class]);
```

### After

```php
 \Illuminate\Support\Facades\Event::fake([MyEvent::class])->assertDispatched([MyEvent::class]);
```

The test may still fail because of `assertDispatched` so it's recommended to refactor to:

```php
Event::fake([MyEvent::class]);
// dispatch your event here...
Event::assertDispatched(MyEvent::class);
```

If you have multiple events, call `assertDispatched` for each event:

```php
Event::fake([MyEvent1::class, MyEvent2::class]);
// ...
Event::assertDispatched(MyEvent1::class);
Event::assertDispatched(MyEvent2::class);
```

## License

[MIT](LICENSE)
