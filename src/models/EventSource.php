<?php

namespace boundstate\eventful\models;

use craft\base\ElementInterface;
use craft\base\Model;
use craft\elements\User;
use craft\helpers\Inflector;

/**
 * @property string $label
 * @property-read ?string $cpUrl
 * @property-read ?string $actionUrl
 */
abstract class EventSource extends Model
{
    public string $dateFieldHandle;

    public string $color;

    /**
     * Returns the element type this source is for.
     *
     * @return class-string<ElementInterface>
     */
    abstract public static function elementType(): string;

    /**
     * Returns sources that should be registered for this type.
     *
     * @return array<string, array> keyed by source key, values are config arrays
     */
    public static function sources(): array
    {
        return [];
    }

    abstract public function criteria(): array;

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
