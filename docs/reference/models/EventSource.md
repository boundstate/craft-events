---
title: EventSource
---

# Class EventSource

A source of events displayed in the calendar.

<small class="block">Extends <span class="code">[Model](https://docs.craftcms.com/api/v5/craft-base-model.html '\\craft\\base\\Model')</span></small>

## Properties

### type

```php
public EventType $type
```

### displayName

```php
public string $displayName
```

### pluralDisplayName

```php
public string $pluralDisplayName
```

### color

```php
public string $color
```

### customQueryParams

```php
public array $customQueryParams
```

## Methods

### fromType

```php
public static fromType(EventType $type, string $color): EventSource
```

|            |                                                                                                       |     |
| ---------- | ----------------------------------------------------------------------------------------------------- | --- |
| `$type`    | <span class="code">[EventType](../base/EventType.md '\\boundstate\\eventful\\base\\EventType')</span> |     |
| `$color`   | <span class="code">string</span>                                                                      |     |
| **return** | <span class="code">[EventSource](EventSource.md '\\boundstate\\eventful\\models\\EventSource')</span> |     |
