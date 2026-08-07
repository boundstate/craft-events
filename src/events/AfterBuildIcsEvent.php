<?php

namespace boundstate\eventful\events;

use boundstate\eventful\models\IcsEvent;
use craft\base\ElementInterface;
use yii\base\Event;

/**
 * Event for customizing ICS events before they are exported.
 */
class AfterBuildIcsEvent extends Event
{
    public ElementInterface $element;

    public IcsEvent $icsEvent;

    public array $attendees;
}
