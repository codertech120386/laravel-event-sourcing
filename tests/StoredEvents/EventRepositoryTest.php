<?php

namespace Tests;

use Tests\TestCase;

use Tests\TestClasses\TestEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\EventSourcing\StoredEvents\StoredEvent;
use Spatie\EventSourcing\StoredEvents\EventRepository;

class EventRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function an_event_can_be_stored() 
    {
        $event = new TestEvent('name');
        $repository = app(EventRepository::class);

        $repository->add($event);

        $this->assertDatabaseHas(
            table: (new StoredEvent())->getTable(),
            data: [
                'event' => $event::class,
            ]
        );

        $this->assertEquals(1, 1);
    }
}