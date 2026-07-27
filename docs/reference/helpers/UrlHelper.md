---
title: UrlHelper
---

# Abstract Class UrlHelper

<small class="block">Extends <span class="code">[UrlHelper](https://docs.craftcms.com/api/v5/craft-helpers-urlhelper.html '\\craft\\helpers\\UrlHelper')</span></small>

## Methods

### hostname

Returns the hostname of the current site (e.g. `example.com`).

Falls back to the primary site if no current site is set (e.g. console requests),
or if the current site doesn't have its own base URL.

```php
public static hostname(): string
```

|            |                                  |     |
| ---------- | -------------------------------- | --- |
| **return** | <span class="code">string</span> |     |
