<?php

declare(strict_types=1);

namespace Package\Tests\Rector\Fixture;

class SomeClassTest
{
    public function testExpectsEvents(): void
    {
        $this->expectsEventsFoo([EventA::class, EventB::class]);
        $foo->expectsEvents([Job::class]);
    }

    public function testExpectsJobs(): void
    {
        $this->expectsJobsBar([Job::class]);
        $bar->expectsJobs([Job::class]);
    }

    public function testExpectsNotifications(): void
    {
        $this->expectsNotificationsBaz([
            NotificationA::class,
            NotificationB::class,
        ]);
        $baz->expectsNotifications([Job::class]);
    }
}

$expectsEvents([EventA::class]);
