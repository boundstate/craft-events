<?php

namespace boundstate\eventful\models;

use boundstate\eventful\base\EventType;
use craft\base\Model;

/**
 * A source of events displayed in the calendar.
 */
class EventSource extends Model
{
    public static function fromType(EventType $type, string $color): EventSource
    {
        return new EventSource([
            'type' => $type,
            'displayName' => $type->displayName(),
            'pluralDisplayName' => $type->pluralDisplayName(),
            'color' => $color,
        ]);
    }

    public EventType $type;

    public string $displayName;

    public string $pluralDisplayName;

    public string $color;

    public array $customQueryParams = [];
}
