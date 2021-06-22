<?php

namespace Tests;

use Tests\TestCase;
use Spatie\EventSourcing\EventBus;
use App\Models\User;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\EventSourcing\StoredEvents\StoredEvent;

class EventBusTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function test_dispatch()
    {
        $bus = app(EventBus::class);

        $subscriber = new TestSubscriber();

        $bus->register($subscriber);

        $bus->dispatch(new EventA());

        $this->assertEquals([EventA::class], $subscriber->log);

        $bus->dispatch(new EventA());
        $bus->dispatch(new EventB());

        $this->assertEquals([
                EventA::class,
                EventA::class,
                EventB::class]
            , $subscriber->log);

        $this->assertEquals(3, StoredEvent::query()->count());
    }
}

class EventA extends ShouldBeStored {

}

class EventB extends ShouldBeStored {

}

class TestSubscriber {

    public array $log = [];

    public function handlesA(EventA $event): void
    {
        $this->log[] = $event::class;
    }

    public function handlesB(EventB $event): void
    {
        $this->log[] = $event::class;
    }

}
