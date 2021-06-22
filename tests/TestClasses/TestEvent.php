<?php

namespace Tests\TestClasses;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class TestEvent extends ShouldBeStored
{
    public function __construct(public string $name)
    {    
    }
}