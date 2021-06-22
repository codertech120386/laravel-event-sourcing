<?php

namespace Spatie\EventSourcing\StoredEvents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoredEvent extends Model
{
    use HasFactory;

    protected $guarded = [];
}
