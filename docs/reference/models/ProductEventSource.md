---
title: ProductEventSource
---

# Class ProductEventSource

<small class="block">Extends <span class="code">[EventSource](EventSource.md '\\boundstate\\eventful\\models\\EventSource')</span></small>

## Properties

### productType

```php
public ProductType $productType
```

## Methods

### elementType

Returns the element type this source is for.

```php
public static elementType(): class-string<ElementInterface>
```

|            |                                                                                                                                                                       |     |
| ---------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --- |
| **return** | <span class="code">class-string&lt;[ElementInterface](https://docs.craftcms.com/api/v5/craft-base-elementinterface.html '\\craft\\base\\ElementInterface')&gt;</span> |     |

### sources

Returns sources that should be registered for this type.

```php
public static sources(): array<string,array>
```

|            |                                                     |                                               |
| ---------- | --------------------------------------------------- | --------------------------------------------- |
| **return** | <span class="code">array&lt;string,array&gt;</span> | keyed by source key, values are config arrays |

### displayName

```php
public displayName(): string
```

|            |                                  |     |
| ---------- | -------------------------------- | --- |
| **return** | <span class="code">string</span> |     |

### criteria

```php
public criteria(): array
```

|            |                                 |     |
| ---------- | ------------------------------- | --- |
| **return** | <span class="code">array</span> |     |

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
