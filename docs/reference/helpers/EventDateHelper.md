---
title: EventDateHelper
---

# Abstract Class EventDateHelper

Helper class for working with event dates.

## Methods

### formatDate

Formats a `Recurrence` as a date (and times if not all day).

```php
public static formatDate(Recurrence $event, "medium"|"long" $format = 'medium', ?string $timezone = null, bool $allDay = false, bool $displayTimezone = false): string
```

|                    |                                                                                                                                         |     |
| ------------------ | --------------------------------------------------------------------------------------------------------------------------------------- | --- |
| `$event`           | <span class="code">[Recurrence](https://github.com/simshaun/recurr/blob/v5.0.3/src/Recurr/Recurrence.php '\\Recurr\\Recurrence')</span> |     |
| `$format`          | <span class="code">"medium"\|"long"</span>                                                                                              |     |
| `$timezone`        | <span class="code">?string</span>                                                                                                       |     |
| `$allDay`          | <span class="code">bool</span>                                                                                                          |     |
| `$displayTimezone` | <span class="code">bool</span>                                                                                                          |     |
| **return**         | <span class="code">string</span>                                                                                                        |     |

### formatDateRange

Formats the value of an `EventDate` field as a date range.

```php
public static formatDateRange(EventDate $event, "medium"|"long"|"mediumDate"|"longDate"|"mediumTime"|"longTime" $format = 'medium', ?string $timezone = null, bool $displayTimezone = false): string
```

|                    |                                                                                                           |     |
| ------------------ | --------------------------------------------------------------------------------------------------------- | --- |
| `$event`           | <span class="code">[EventDate](../models/EventDate.md '\\boundstate\\eventful\\models\\EventDate')</span> |     |
| `$format`          | <span class="code">"medium"\|"long"\|"mediumDate"\|"longDate"\|"mediumTime"\|"longTime"</span>            |     |
| `$timezone`        | <span class="code">?string</span>                                                                         |     |
| `$displayTimezone` | <span class="code">bool</span>                                                                            |     |
| **return**         | <span class="code">string</span>                                                                          |     |
