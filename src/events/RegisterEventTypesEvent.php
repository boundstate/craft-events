<?php

namespace boundstate\eventful\events;

use boundstate\eventful\base\EventType;
use yii\base\Event;

/**
 * Event for customizing event types.
 */
class RegisterEventTypesEvent extends Event
{
    /**
     * @var array<class-string<EventType>>
     */
    public array $types = [];
}
