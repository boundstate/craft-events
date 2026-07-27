<?php

namespace boundstate\eventful\events;

use boundstate\eventful\models\EventSource;
use yii\base\Event;

/**
 * Event for customizing event source types.
 */
class RegisterEventSourceTypesEvent extends Event
{
    /**
     * @var array<class-string<EventSource>>
     */
    public array $types = [];
}
