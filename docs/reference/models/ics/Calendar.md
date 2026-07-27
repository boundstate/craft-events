---
title: Calendar
---

# Class Calendar

<small class="block">Extends <span class="code">[Model](https://docs.craftcms.com/api/v5/craft-base-model.html '\\craft\\base\\Model')</span></small>

## Constants

### METHOD_PUBLISH

Post notification of an event.

Used primarily as a method of advertising the existence of an event.

### METHOD_REQUEST

Make a request for an event.

This is an explicit invitation to one or more "Attendees".
Event Requests are also used to update or change an existing event.
Clients that cannot handle REQUEST may degrade the event to view it as a PUBLISH.

### METHOD_CANCEL

Cancel one or more instances of an existing event.

## Methods

### __construct

```php
public __construct(array $config = []): mixed
```

|            |                                 |     |
| ---------- | ------------------------------- | --- |
| `$config`  | <span class="code">array</span> |     |
| **return** | <span class="code">mixed</span> |     |

### setMethod

```php
public setMethod(string $method): static
```

|            |                                  |     |
| ---------- | -------------------------------- | --- |
| `$method`  | <span class="code">string</span> |     |
| **return** | <span class="code">static</span> |     |

### addEvent

```php
public addEvent(array $config = []): Event
```

|            |                                                                                          |     |
| ---------- | ---------------------------------------------------------------------------------------- | --- |
| `$config`  | <span class="code">array</span>                                                          |     |
| **return** | <span class="code">[Event](Event.md '\\boundstate\\eventful\\models\\ics\\Event')</span> |     |

### serialize

```php
public serialize(): string
```

|            |                                  |     |
| ---------- | -------------------------------- | --- |
| **return** | <span class="code">string</span> |     |

### addTimezones

Adds a timezone definition the calendar.

```php
public addTimezones(): void
```
