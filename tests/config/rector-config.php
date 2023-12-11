<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Remarkablemark\RectorLaravelServiceMocking\LaravelServiceMockingRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(LaravelServiceMockingRector::class);
};
