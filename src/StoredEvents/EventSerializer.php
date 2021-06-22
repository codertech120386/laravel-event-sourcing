<?php

namespace Spatie\EventSourcing\StoredEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class EventSerializer 
{
    public function serialize(ShouldBeStored $event): string {
        return serialize($event);
    }    

    public function unserialize(string $payload): ShouldBeStored {
        return unserialize($payload);
    }
}