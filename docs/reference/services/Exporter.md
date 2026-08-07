---
title: Exporter
---

# Class Exporter

Event Exporter.

<small class="block">Extends <span class="code">[Component](https://www.yiiframework.com/doc/api/2.0/yii-base-component '\\yii\\base\\Component')</span></small>

## Constants

### EVENT_AFTER_BUILD_ICS

See <span class="code">[AfterBuildIcsEvent](../events/AfterBuildIcsEvent.md '\\boundstate\\eventful\\events\\AfterBuildIcsEvent'){ data-preview }</span>

## Methods

### toIcs

Returns ICS file contents.

```php
public toIcs(ElementInterface|ElementInterface[] $elements): string
```

|             |                                                                                                                                                                                                                                                                              |     |
| ----------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --- |
| `$elements` | <span class="code">[ElementInterface](https://docs.craftcms.com/api/v5/craft-base-elementinterface.html '\\craft\\base\\ElementInterface')\|[ElementInterface](https://docs.craftcms.com/api/v5/craft-base-elementinterface.html '\\craft\\base\\ElementInterface')[]</span> |     |
| **return**  | <span class="code">string</span>                                                                                                                                                                                                                                             |     |

### toMultipleIcs

Returns ICS file contents for each calendar event.

```php
public toMultipleIcs(ElementInterface|ElementInterface[] $elements, ?IcsMethod $method = null, User|User[]|string|string[] $attendees = []): string[]
```

|              |                                                                                                                                                                                                                                                                              |                                                     |
| ------------ | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------- |
| `$elements`  | <span class="code">[ElementInterface](https://docs.craftcms.com/api/v5/craft-base-elementinterface.html '\\craft\\base\\ElementInterface')\|[ElementInterface](https://docs.craftcms.com/api/v5/craft-base-elementinterface.html '\\craft\\base\\ElementInterface')[]</span> |                                                     |
| `$method`    | <span class="code">?[IcsMethod](../enums/IcsMethod.md '\\boundstate\\eventful\\enums\\IcsMethod')</span>                                                                                                                                                                     |                                                     |
| `$attendees` | <span class="code">[User](https://docs.craftcms.com/api/v5/craft-elements-user.html '\\craft\\elements\\User')\|[User](https://docs.craftcms.com/api/v5/craft-elements-user.html '\\craft\\elements\\User')[]\|string\|string[]</span>                                       | Array of users or in the format: `[email => name]`. |
| **return**   | <span class="code">string[]</span>                                                                                                                                                                                                                                           |                                                     |
