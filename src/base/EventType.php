<?php

namespace boundstate\eventful\base;

use craft\base\Model;
use craft\elements\db\ElementQuery;
use craft\elements\User;
use craft\helpers\Inflector;

/**
 * @property-read ?string $cpUrl
 * @property-read ?string $actionUrl
 */
abstract class EventType extends Model
{
    /**
     * @var string Handle of the field that contains the event dates.
     */
    public string $dateFieldHandle;

    /**
     * Returns instances of this type.
     *
     * @return array<string, EventType>
     */
    public static function discoverTypes(): array
    {
        return [];
    }

    /**
     * Returns a query for elements of this type.
     *
     * @phpstan-ignore missingType.generics
     */
    abstract public function find(): ElementQuery;

    abstract public function displayName(): string;

    public function pluralDisplayName(): string
    {
        return Inflector::pluralize($this->displayName());
    }

    public function getCpUrl(): ?string
    {
        return null;
    }

    public function getActionUrl(): ?string
    {
        return null;
    }

    public function canView(User $user): bool
    {
        return true;
    }

    public function canViewPeers(User $user): bool
    {
        return true;
    }

    public function canCreate(User $user): bool
    {
        return false;
    }

    public function canDelete(User $user): bool
    {
        return false;
    }
}
