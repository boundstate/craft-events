<?php

namespace boundstate\eventful\web\assets;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class CpCalendarAsset extends AssetBundle
{
    public function init(): void
    {
        $this->sourcePath = __DIR__.'/dist';

        $this->depends = [
            CpAsset::class,
        ];

        $this->css = [
            'calendar.css',
        ];

        $this->js = [
            'calendar.js',
        ];

        $this->jsOptions = [
            'type' => 'module',
        ];

        parent::init();
    }
}
