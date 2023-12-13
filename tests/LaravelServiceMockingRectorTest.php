<?php

declare(strict_types=1);

namespace Remarkablemark\Tests\LaravelServiceMockingRector;

use PHPUnit\Framework\Attributes\DataProvider;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class LaravelServiceMockingRectorTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideCases
     */
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideCases(): iterable
    {
        return self::yieldFilesFromDirectory(__DIR__.'/fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__.'/config/rector-config.php';
    }
}
