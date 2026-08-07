---
title: EventType
---

# Abstract Class EventType

<small class="block">Extends <span class="code">[Model](https://docs.craftcms.com/api/v5/craft-base-model.html '\\craft\\base\\Model')</span></small>

## Properties

### dateFieldHandle

```php
public string $dateFieldHandle
```

## Methods

### discoverTypes

Returns instances of this type.

```php
public static discoverTypes(): array<string,EventType>
```

|            |                                                                                                                   |     |
| ---------- | ----------------------------------------------------------------------------------------------------------------- | --- |
| **return** | <span class="code">array&lt;string,[EventType](EventType.md '\\boundstate\\eventful\\base\\EventType')&gt;</span> |     |

### find

Returns a query for elements of this type.

```php
public find(): ElementQuery
```

|            |                                                                                                                                                      |     |
| ---------- | ---------------------------------------------------------------------------------------------------------------------------------------------------- | --- |
| **return** | <span class="code">[ElementQuery](https://docs.craftcms.com/api/v5/craft-elements-db-elementquery.html '\\craft\\elements\\db\\ElementQuery')</span> |     |

### displayName

```php
public displayName(): string
```

|            |                                  |     |
| ---------- | -------------------------------- | --- |
| **return** | <span class="code">string</span> |     |

### pluralDisplayName

```php
public pluralDisplayName(): string
```

|            |                                  |     |
| ---------- | -------------------------------- | --- |
| **return** | <span class="code">string</span> |     |

### getCpUrl

```php
public getCpUrl(): ?string
```

|            |                                   |     |
| ---------- | --------------------------------- | --- |
| **return** | <span class="code">?string</span> |     |

### getActionUrl

```php
public getActionUrl(): ?string
```

|            |                                   |     |
| ---------- | --------------------------------- | --- |
| **return** | <span class="code">?string</span> |     |

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
