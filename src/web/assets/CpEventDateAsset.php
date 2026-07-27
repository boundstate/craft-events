<?php

namespace boundstate\eventful\web\assets;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class CpEventDateAsset extends AssetBundle
{
    public function init(): void
    {
        $this->sourcePath = __DIR__.'/dist';

        $this->depends = [
            CpAsset::class,
        ];

        $this->css = [
            'event-date-field.css',
        ];

        $this->js = [
            'event-date-field.js',
        ];

        $this->jsOptions = [
            'type' => 'module',
        ];

        parent::init();
    }
}
