<?php

namespace boundstate\eventful\events;

use boundstate\eventful\models\EventSource;
use yii\base\Event;

/**
 * Event for customizing event sources.
 */
class RegisterEventSourcesEvent extends Event
{
    /**
     * @var array<EventSource>
     */
    public array $sources = [];
}
