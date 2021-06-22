<?php

namespace Spatie\EventSourcing;

use Spatie\EventSourcing\StoredEvents\EventRepository;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class EventBus {

    private array $subscribers = [];

    /**
     * @param EventReository $eventRepository
     */
    public function __construct(private EventRepository $eventRepository) {}

    public function register(object $subscriber): self {
        $this->subscribers[$subscriber::class] = new SubscriberReflection($subscriber);

        return $this;
    }

    public function dispatch(ShouldBeStored $event): void {
        $this->eventRepository->add($event);
        foreach ($this->subscribers as $reflection) {
            $handlerMethod = $reflection->handlerFor($event);

            if (! $handlerMethod) continue;

            $reflection->subscriber->{$handlerMethod}($event);
        }
    }
}
