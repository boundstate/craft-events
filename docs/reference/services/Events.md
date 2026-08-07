---
title: Events
---

# Class Events

<small class="block">Extends <span class="code">[Component](https://www.yiiframework.com/doc/api/2.0/yii-base-component '\\yii\\base\\Component')</span></small>

## Constants

### EVENT_REGISTER_SOURCE_TYPES

See <span class="code">[RegisterEventSourceTypesEvent](../events/RegisterEventSourceTypesEvent.md '\\boundstate\\eventful\\events\\RegisterEventSourceTypesEvent'){ data-preview }</span>

### EVENT_REGISTER_SOURCES

See <span class="code">[RegisterEventSourcesEvent](../events/RegisterEventSourcesEvent.md '\\boundstate\\eventful\\events\\RegisterEventSourcesEvent'){ data-preview }</span>

## Methods

### findDateField

```php
public findDateField(ElementInterface|FieldLayoutProviderInterface $type): ?EventDate
```

|            |                                                                                                                                                                                                                                                                                                                |     |
| ---------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --- |
| `$type`    | <span class="code">[ElementInterface](https://docs.craftcms.com/api/v5/craft-base-elementinterface.html '\\craft\\base\\ElementInterface')\|[FieldLayoutProviderInterface](https://docs.craftcms.com/api/v5/craft-base-fieldlayoutproviderinterface.html '\\craft\\base\\FieldLayoutProviderInterface')</span> |     |
| **return** | <span class="code">?[EventDate](../fields/EventDate.md '\\boundstate\\eventful\\fields\\EventDate')</span>                                                                                                                                                                                                     |     |

### getSourceTypes

```php
public getSourceTypes(): class-string<EventSource>[]
```

|            |                                                                                                                                   |     |
| ---------- | --------------------------------------------------------------------------------------------------------------------------------- | --- |
| **return** | <span class="code">class-string&lt;[EventSource](../base/EventSource.md '\\boundstate\\eventful\\base\\EventSource')&gt;[]</span> |     |

### getSources

```php
public getSources(): array<string,EventSource>
```

|            |                                                                                                                                 |     |
| ---------- | ------------------------------------------------------------------------------------------------------------------------------- | --- |
| **return** | <span class="code">array&lt;string,[EventSource](../base/EventSource.md '\\boundstate\\eventful\\base\\EventSource')&gt;</span> |     |

### findSourceByKey

```php
public findSourceByKey(string $key): EventSource
```

|            |                                                                                                             |     |
| ---------- | ----------------------------------------------------------------------------------------------------------- | --- |
| `$key`     | <span class="code">string</span>                                                                            |     |
| **return** | <span class="code">[EventSource](../base/EventSource.md '\\boundstate\\eventful\\base\\EventSource')</span> |     |

### getEvents

```php
public getEvents(mixed $date = null, ?array $extraCriteria = null, string[]|null $sourceKeys = null, User|null $user = null): array<string,ElementInterface[]>
```

|                  |                                                                                                                                                                         |                                        |
| ---------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------- |
| `$date`          | <span class="code">mixed</span>                                                                                                                                         |                                        |
| `$extraCriteria` | <span class="code">?array</span>                                                                                                                                        |                                        |
| `$sourceKeys`    | <span class="code">string[]\|null</span>                                                                                                                                |                                        |
| `$user`          | <span class="code">[User](https://docs.craftcms.com/api/v5/craft-elements-user.html '\\craft\\elements\\User')\|null</span>                                             | only return events the user can access |
| **return**       | <span class="code">array&lt;string,[ElementInterface](https://docs.craftcms.com/api/v5/craft-base-elementinterface.html '\\craft\\base\\ElementInterface')[]&gt;</span> |                                        |

### updateICalendarSequence

```php
public updateICalendarSequence(int $elementId): void
```

|              |                               |     |
| ------------ | ----------------------------- | --- |
| `$elementId` | <span class="code">int</span> |     |
