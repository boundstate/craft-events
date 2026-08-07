---
title: ProductEventType
---

# Class ProductEventType

<small class="block">Extends <span class="code">[EventType](../base/EventType.md '\\boundstate\\eventful\\base\\EventType')</span></small>

## Properties

### productType

```php
public ProductType $productType
```

## Methods

### discoverTypes

Returns instances of this type.

```php
public static discoverTypes(): array<string,EventType>
```

|            |                                                                                                                           |     |
| ---------- | ------------------------------------------------------------------------------------------------------------------------- | --- |
| **return** | <span class="code">array&lt;string,[EventType](../base/EventType.md '\\boundstate\\eventful\\base\\EventType')&gt;</span> |     |

### displayName

```php
public displayName(): string
```

|            |                                  |     |
| ---------- | -------------------------------- | --- |
| **return** | <span class="code">string</span> |     |

### find

Returns a query for elements of this type.

```php
public find(): ProductQuery
```

|            |                                                                                                                                                                         |     |
| ---------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --- |
| **return** | <span class="code">[ProductQuery](https://docs.craftcms.com/api/v5/craft-commerce-elements-db-productquery.html '\\craft\\commerce\\elements\\db\\ProductQuery')</span> |     |

### getCpUrl

```php
public getCpUrl(): string
```

|            |                                  |     |
| ---------- | -------------------------------- | --- |
| **return** | <span class="code">string</span> |     |

### getActionUrl

```php
public getActionUrl(): string
```

|            |                                  |     |
| ---------- | -------------------------------- | --- |
| **return** | <span class="code">string</span> |     |

### canView

```php
public canView(User $user): bool
```

|            |                                                                                                                       |     |
| ---------- | --------------------------------------------------------------------------------------------------------------------- | --- |
| `$user`    | <span class="code">[User](https://docs.craftcms.com/api/v5/craft-elements-user.html '\\craft\\elements\\User')</span> |     |
| **return** | <span class="code">bool</span>                                                                                        |     |

### canViewPeers

```php
public canViewPeers(User $user): bool
```

|            |                                                                                                                       |     |
| ---------- | --------------------------------------------------------------------------------------------------------------------- | --- |
| `$user`    | <span class="code">[User](https://docs.craftcms.com/api/v5/craft-elements-user.html '\\craft\\elements\\User')</span> |     |
| **return** | <span class="code">bool</span>                                                                                        |     |

### canCreate

```php
public canCreate(User $user): bool
```

|            |                                                                                                                       |     |
| ---------- | --------------------------------------------------------------------------------------------------------------------- | --- |
| `$user`    | <span class="code">[User](https://docs.craftcms.com/api/v5/craft-elements-user.html '\\craft\\elements\\User')</span> |     |
| **return** | <span class="code">bool</span>                                                                                        |     |

### canDelete

```php
public canDelete(User $user): bool
```

|            |                                                                                                                       |     |
| ---------- | --------------------------------------------------------------------------------------------------------------------- | --- |
| `$user`    | <span class="code">[User](https://docs.craftcms.com/api/v5/craft-elements-user.html '\\craft\\elements\\User')</span> |     |
| **return** | <span class="code">bool</span>                                                                                        |     |
