<?php

namespace Package\Tests\Rector\Fixture;

class SomeClassTest
{
    public function testExpectsEvents(): void
    {
        $this->expectsEventsFoo([EventA::class, EventB::class]);
    }

    public function testExpectsJobs(): void
    {
        $bar->expectsJobsBar([Job::class]);
    }

    public function testExpectsNotifications(): void
    {
        $this->expectsNotificationsBaz([
            NotificationA::class,
            NotificationB::class,
        ]);
    }
}
