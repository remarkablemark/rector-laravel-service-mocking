<?php

declare(strict_types=1);

namespace Package\Tests\Rector\Fixture;

class SomeClassTest
{
    public function testExpectsEvents(): void
    {
        $this->expectsEvents([EventA::class, EventB::class]);
    }

    public function testDoesntExpectEvents(): void
    {
        $this->doesntExpectEvents([EventA::class, EventB::class]);
    }

    public function testExpectsJobs(): void
    {
        $this->expectsJobs([Job::class]);
    }

    public function testDoesntExpectJobs(): void
    {
        $this->doesntExpectJobs([Job::class]);
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

declare(strict_types=1);

namespace Package\Tests\Rector\Fixture;

class SomeClassTest
{
    public function testExpectsEvents(): void
    {
        \Illuminate\Support\Facades\Event::fake([EventA::class, EventB::class])->assertDispatched([EventA::class, EventB::class]);
    }

    public function testDoesntExpectEvents(): void
    {
        \Illuminate\Support\Facades\Event::fake([EventA::class, EventB::class])->assertNotDispatched([EventA::class, EventB::class]);
    }

    public function testExpectsJobs(): void
    {
        \Illuminate\Support\Facades\Bus::fake([Job::class])->assertDispatched([Job::class]);
    }

    public function testDoesntExpectJobs(): void
    {
        \Illuminate\Support\Facades\Bus::fake([Job::class])->assertNotDispatched([Job::class]);
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
