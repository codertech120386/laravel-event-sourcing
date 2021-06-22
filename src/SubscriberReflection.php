<?php

namespace Spatie\EventSourcing;

use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;

class SubscriberReflection {
    private ReflectionClass $reflection;
    public object $subscriber;

    public function __construct(object $subscriber) {
        $this->reflection = new ReflectionClass($subscriber);

        $this->subscriber = $subscriber;
    }

    // we are trying to check if subscriber has a method that handles the event
    public function handlerFor(object $event): ?string {

        // first we collect all the methods in the subscriber and 
        // try to find the first method that handles the event

        $handlerMethod = collect($this->reflection->getMethods(ReflectionMethod::IS_PUBLIC))
            ->first(function(ReflectionMethod $method) use ($event) {
                
                $firstParameter = $method->getParameters()[0] ?? null;

                if(! $firstParameter) return false;

                $type = $firstParameter->getType();

                if(! $type instanceof ReflectionNamedType) return false;

                return $type->getName() === $event::class;
            });
               
        // return the method name that handles the event if it exists else null
        return $handlerMethod?->getName();
    }
}