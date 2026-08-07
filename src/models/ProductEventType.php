<?php

namespace boundstate\eventful\models;

use boundstate\eventful\base\EventType;
use boundstate\eventful\Eventful;
use craft\commerce\elements\db\ProductQuery;
use craft\commerce\elements\Product;
use craft\commerce\models\ProductType;
use craft\commerce\Plugin;
use craft\elements\User;
use craft\helpers\UrlHelper;

class ProductEventType extends EventType
{
    public ProductType $productType;

    public static function discoverTypes(): array
    {
        $productTypes = Plugin::getInstance()->productTypes->getAllProductTypes();

        $types = [];
        foreach ($productTypes as $productType) {
            $dateField = Eventful::getInstance()->events->findDateField($productType);
            if ($dateField) {
                $types["productType:$productType->handle"] = new ProductEventType([
                    'dateFieldHandle' => $dateField->handle,
                    'productType' => $productType,
                ]);
            }
        }

        return $types;
    }

    public function displayName(): string
    {
        return $this->productType->name;
    }

    // @phpstan-ignore missingType.generics
    public function find(): ProductQuery
    {
        return Product::find()->type($this->productType->handle);
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
