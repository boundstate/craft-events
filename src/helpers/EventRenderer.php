<?php

namespace boundstate\eventful\helpers;

use boundstate\eventful\enums\EventProp;
use boundstate\eventful\Eventful;
use Craft;
use craft\base\ElementInterface;

/**
 * Helper class for rendering event properties.
 */
abstract class EventRenderer
{
    /**
     * Renders the event property using the configured template.
     *
     * @param  ElementInterface  $element  Event to render
     * @param  EventProp  $prop  Property to render
     * @param  bool  $ics  Whether this is being rendered for an ICS file
     */
    public static function render(ElementInterface $element, EventProp $prop, bool $ics = false): string
    {
        $value = Craft::$app->view->renderObjectTemplate(
            Eventful::getInstance()->settings['event'.ucfirst($prop->value).'Template'],
            $element,
            ['ics' => $ics],
        );

        return $ics ? strip_tags($value) : $value;
    }
}
