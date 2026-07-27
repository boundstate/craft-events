<?php

use craft\web\Application;

/**
 * Craft web bootstrap file
 */

// Load shared bootstrap
require dirname(__DIR__).'/bootstrap.php';

// Load and run Craft
/** @var Application $app */
$app = require CRAFT_VENDOR_PATH.'/craftcms/cms/bootstrap/web.php';
$app->run();
