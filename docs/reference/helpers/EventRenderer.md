---
title: EventRenderer
---

# Abstract Class EventRenderer

Helper class for rendering event properties.

## Methods

### render

Renders the event property using the configured template.

```php
public static render(ElementInterface $element, EventProp $prop, bool $ics = false): string
```

|            |                                                                                                                                                   |                                                |
| ---------- | ------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------- |
| `$element` | <span class="code">[ElementInterface](https://docs.craftcms.com/api/v5/craft-base-elementinterface.html '\\craft\\base\\ElementInterface')</span> | Event to render                                |
| `$prop`    | <span class="code">[EventProp](../enums/EventProp.md '\\boundstate\\eventful\\enums\\EventProp')</span>                                           | Property to render                             |
| `$ics`     | <span class="code">bool</span>                                                                                                                    | Whether this is being rendered for an ICS file |
| **return** | <span class="code">string</span>                                                                                                                  |                                                |
