---
icon: lucide/zap
---

# Triggered events

This plugin triggers several events to allow greater customization for developers:

<!-- prettier-ignore -->
!!! tip ""
    Craft CMS has a [tutorial](https://craftcms.com/knowledge-base/custom-module-events) on wiring up your first event handler in a module.

## Events

### [Register source types](reference/services/Events.md#event_register_source_types)

Event triggered when registering types of event sources.

```php
Event::on(
    Events::class,
    Events::EVENT_REGISTER_SOURCE_TYPES,
    function (RegisterEventSourceTypesEvent $e) {
        $e->types[] = Meeting::class;
    }
);
```

### [Register sources](reference/services/Events.md#event_register_sources)

Event triggered when registering event sources.
The built-in source types for entries and products will register an event source for each entry type and product type that has an event date field.

```php
Event::on(
    Events::class,
    Events::EVENT_REGISTER_SOURCES,
    function (RegisterEventSourcesEvent $e) {
        foreach ($e->sources as $key => $source) {
            if ($key === 'entry:meetings:meeting') {
                $source->color = Color::PISTACHIO->value;
            }
        }
    }
);
```

## Exporter

### [After build ICS](reference/services/Exporter.md#event_after_build_ics)

Event triggered after building the ICS object but before exporting the file.

```php
Event::on(
    Exporter::class,
    Exporter::EVENT_AFTER_BUILD_ICS,
    function (AfterBuildIcsEvent $event) {
        $event->icsEvent->setUid($event->element->relatedEntry->uid);
    }
);
```
