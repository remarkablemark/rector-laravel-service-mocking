<?php

namespace Package\Tests\Rector\Fixture;

class SomeClassTest
{
    public function testExpectsEvents(): void
    {
        $this->expectsEvents([EventA::class, EventB::class]);
    }

    public function testExpectsJobs(): void
    {
        $this->expectsJobs([Job::class]);
    }

    public function testExpectsNotification(): void
    {
        $this->expectsNotification([
            NotificationA::class,
            NotificationB::class,
        ]);
    }
}
-----
<?php

namespace Package\Tests\Rector\Fixture;

class SomeClassTest
{
    public function testExpectsEvents(): void
    {
        \Illuminate\Support\Facades\Event::fake([EventA::class, EventB::class])->assertDispatched([EventA::class, EventB::class]);
    }

    public function testExpectsJobs(): void
    {
        \Illuminate\Support\Facades\Queue::fake([Job::class])->assertPushed([Job::class]);
    }

    public function testExpectsNotification(): void
    {
        \Illuminate\Support\Facades\Notification::fake([
            NotificationA::class,
            NotificationB::class,
        ])->assertSentTo([
            NotificationA::class,
            NotificationB::class,
        ]);
    }
}
