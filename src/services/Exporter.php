<?php

namespace boundstate\eventful\services;

use boundstate\eventful\enums\EventProp;
use boundstate\eventful\Eventful;
use boundstate\eventful\events\AfterBuildIcsEvent;
use boundstate\eventful\helpers\EventRenderer;
use boundstate\eventful\helpers\UrlHelper;
use boundstate\eventful\models\EventDate;
use boundstate\eventful\models\ics\Calendar;
use boundstate\eventful\models\ics\Event;
use boundstate\eventful\records\Metadata;
use Craft;
use craft\base\ElementInterface;
use craft\elements\User;
use craft\errors\InvalidFieldException;
use craft\helpers\MailerHelper;
use yii\base\Component;

/**
 * Event Exporter.
 */
class Exporter extends Component
{
    /**
     * @see AfterBuildIcsEvent
     */
    const EVENT_AFTER_BUILD_ICS = 'beforeExport';

    /**
     * Returns ICS file contents.
     *
     * @param  ElementInterface|array<ElementInterface>  $elements
     */
    public function toIcs(mixed $elements): string
    {
        if (! is_array($elements)) {
            $elements = [$elements];
        }

        $calendar = new Calendar;
        foreach ($elements as $element) {
            $this->addEvent($calendar, $element);
        }
        $calendar->addTimezones();

        return $calendar->serialize();
    }

    /**
     * Returns ICS file contents for each calendar event.
     *
     * @param  ElementInterface|array<ElementInterface>  $elements
     * @param  User|array<User>|string|array<string>  $attendees  Array of users or in the format: `[email => name]`.
     * @param  ?string  $method  https://datatracker.ietf.org/doc/html/rfc2446#section-3.2
     * @return string[]
     */
    public function toMultipleIcs(
        mixed $elements,
        mixed $attendees = [],
        ?string $method = null,
    ): array {
        if (! is_array($elements)) {
            $elements = [$elements];
        }

        $attendees = MailerHelper::normalizeEmails($attendees);

        return array_map(function ($element) use ($attendees, $method): string {
            $calendar = new Calendar;
            $calendar->setMethod($method);
            $this->addEvent($calendar, $element, $attendees, $method);
            $calendar->addTimezones();

            return $calendar->serialize();
        }, $elements);
    }

    /**
     * Adds an event to a calendar.
     *
     * @throws InvalidFieldException
     */
    private function addEvent(
        Calendar $calendar,
        ElementInterface $element,
        array $attendees = [],
        ?string $method = null,
    ): void {
        $dateField = Eventful::getInstance()->events->findDateField($element);

        /** @var EventDate $date */
        $date = $element->getFieldValue($dateField->handle);

        $metadata = Metadata::findOne(['id' => $element->id]);

        $event = $calendar
            ->addEvent()
            ->setUid($element->uid)
            ->setSequence($metadata->iCalendarSequence ?? 0)
            ->setStart($date->start)
            ->setEnd($date->end)
            ->setSummary(EventRenderer::render($element, EventProp::TITLE, ics: true))
            ->setDescription(EventRenderer::render($element, EventProp::DESCRIPTION, ics: true))
            ->setLocation(EventRenderer::render($element, EventProp::LOCATION, ics: true));

        if ($date->rule) {
            $event->setRule($date->rule);
        }

        if ($method === Calendar::METHOD_CANCEL) {
            $event->setStatus(Event::STATUS_CANCELLED);
        }

        $host = UrlHelper::hostname();
        $event->addOrganizers([
            "noreply@$host" => Craft::$app->sites->currentSite->name,
        ]);

        $event->addAttendees($attendees);

        $this->trigger(self::EVENT_AFTER_BUILD_ICS, new AfterBuildIcsEvent([
            'element' => $element,
            'icsEvent' => $event,
            'attendees' => $attendees,
        ]));
    }
}
