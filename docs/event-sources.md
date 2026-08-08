---
icon: lucide/square-arrow-right-enter
---

# Event sources

Once an event date field is added to an [entry type](https://craftcms.com/docs/5.x/reference/element-types/entries.html#entry-types) or [product type](https://craftcms.com/docs/commerce/5.x/system/products-variants.html#product-types),
a new source will be automatically displayed on the calendar.

## Customization

To customize the sources displayed on the calendar,
use the [Register Sources](triggered-events.md#register-sources){ data-preview } event.

## Custom types

To allow a custom [element type](https://craftcms.com/docs/5.x/extend/element-types.html) to be displayed on the calendar:

1. Subclass [`EventType`](reference/base/EventType.md)
2. Use the [Register Source Types](triggered-events.md#register-types){ data-preview } event to register your custom class
