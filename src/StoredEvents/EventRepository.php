<?php

namespace Spatie\EventSourcing\StoredEvents;


class EventRepository
{

    public function __construct(private EventSerializer $serializer) 
    { 
    }

    public function add(ShouldBeStored $event): void
    {
        $payload = $this->serializer->serialize($event);

        $storedEvent = StoredEvent::create([
            'event' => $event::class,
            'payload' => $payload
        ]);

        $event->setStoredEventId($storedEvent->id);
    }
}