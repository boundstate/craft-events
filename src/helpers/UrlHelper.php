<?php

namespace boundstate\eventful\helpers;

use Craft;
use craft\helpers\UrlHelper as BaseUrlHelper;

abstract class UrlHelper extends BaseUrlHelper
{
    /**
     * Returns the hostname of the current site (e.g. `example.com`).
     * Falls back to the primary site if no current site is set (e.g. console requests),
     * or if the current site doesn't have its own base URL.
     */
    public static function hostname(): string
    {
        $baseUrl = Craft::$app->sites->currentSite->baseUrl ?? Craft::$app->sites->primarySite->baseUrl;

        return parse_url($baseUrl, PHP_URL_HOST);
    }
}
