<?php

namespace boundstate\eventful\models;

use boundstate\eventful\base\EventSource;
use boundstate\eventful\fields\EventDate as EventDateField;
use craft\commerce\elements\Product;
use craft\commerce\models\ProductType;
use craft\commerce\Plugin;
use craft\elements\User;
use craft\helpers\ArrayHelper;
use craft\helpers\UrlHelper;

class ProductEventSource extends EventSource
{
    public ProductType $productType;

    public static function elementType(): string
    {
        return Product::class;
    }

    public static function sources(): array
    {
        $productTypes = Plugin::getInstance()->productTypes->getAllProductTypes();

        $sources = [];
        foreach ($productTypes as $productType) {
            $dateField = ArrayHelper::firstWhere($productType->getFieldLayout()->getCustomFields(), fn ($field) => $field instanceof EventDateField);
            if ($dateField) {
                $sources["productType:$productType->handle"] = [
                    'dateFieldHandle' => $dateField->handle,
                    'productType' => $productType,
                ];
            }
        }

        return $sources;
    }

    public function displayName(): string
    {
        return $this->productType->name;
    }

    public function criteria(): array
    {
        return [
            'type' => $this->productType->handle,
        ];
    }

    public function getCpUrl(): string
    {
        return UrlHelper::cpUrl("commerce/products/{$this->productType->handle}/new");
    }

    public function getActionUrl(): string
    {
        return UrlHelper::actionUrl('commerce/products/create', [
            'productType' => $this->productType->handle,
        ]);
    }

    public function canView(User $user): bool
    {
        return $this->hasProductTypePermission($user, 'view');
    }

    public function canViewPeers(User $user): bool
    {
        // Commerce dosn't have a separate permission for this
        return $this->canView($user);
    }

    public function canCreate(User $user): bool
    {
        return $this->hasProductTypePermission($user, 'create');
    }

    public function canDelete(User $user): bool
    {
        return $this->hasProductTypePermission($user, 'delete');
    }

    private function hasProductTypePermission(User $user, string $permission): bool
    {
        return $user->can("commerce-{$permission}ProductType:{$this->productType->uid}");
    }
}
