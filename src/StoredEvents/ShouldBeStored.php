<?php

namespace Spatie\EventSourcing\StoredEvents;

abstract class ShouldBeStored {

    private ?int $storedEventId = null;

    public function setStoredEventId(int $storedEventId): self {
        $this->storedEventId = $storedEventId;

        return $this;
    }
}