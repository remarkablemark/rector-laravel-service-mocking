<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Remarkablemark\RectorTemplate\ExampleRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(ExampleRector::class);
};
