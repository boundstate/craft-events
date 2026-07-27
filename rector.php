<?php

use craft\rector\SetList as CraftSetList;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/config',
        __DIR__.'/migrations',
        __DIR__.'/modules',
    ])
    ->withPhpSets()
    ->withPreparedSets(
        deadCode: true,
        typeDeclarations: true,
    )
    ->withSets([SetList::DEAD_CODE, CraftSetList::CRAFT_CMS_50]);
