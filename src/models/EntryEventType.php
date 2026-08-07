<?php

namespace boundstate\eventful\models;

use boundstate\eventful\base\EventType;
use boundstate\eventful\Eventful;
use Craft;
use craft\elements\db\EntryQuery;
use craft\elements\Entry;
use craft\elements\User;
use craft\helpers\UrlHelper;
use craft\models\EntryType;
use craft\models\Section;

class EntryEventType extends EventType
{
    public Section $section;

    public EntryType $entryType;

    public static function discoverTypes(): array
    {
        $sections = Craft::$app->entries->getAllSections();

        $types = [];
        foreach ($sections as $section) {
            foreach ($section->getEntryTypes() as $entryType) {
                $dateField = Eventful::getInstance()->events->findDateField($entryType);
                if ($dateField) {
                    $types["entry:$section->handle:$entryType->handle"] = new EntryEventType([
                        'dateFieldHandle' => $dateField->handle,
                        'section' => $section,
                        'entryType' => $entryType,
                    ]);
                }
            }
        }

        return $types;
    }

    public function displayName(): string
    {
        return $this->entryType->name;
    }

    public function pluralDisplayName(): string
    {
        return $this->section->name;
    }

    // @phpstan-ignore missingType.generics
    public function find(): EntryQuery
    {
        return Entry::find()
            ->section($this->section->handle)
            ->type($this->entryType->handle);
    }

    public function getCpUrl(): string
    {
        return UrlHelper::cpUrl("entries/{$this->section->handle}/new");
    }

    public function getActionUrl(): string
    {
        return UrlHelper::actionUrl('entries/create', [
            'section' => $this->section->handle,
        ]);
    }

    public function canView(User $user): bool
    {
        return $this->hasEntryPermission($user, 'view');
    }

    public function canViewPeers(User $user): bool
    {
        return $this->hasEntryPermission($user, 'viewPeer');
    }

    public function canCreate(User $user): bool
    {
        return $this->hasEntryPermission($user, 'create');
    }

    public function canDelete(User $user): bool
    {
        return $this->hasEntryPermission($user, 'delete');
    }

    private function hasEntryPermission(User $user, string $permission): bool
    {
        return $user->can("{$permission}Entries:{$this->section->uid}");
    }
}
