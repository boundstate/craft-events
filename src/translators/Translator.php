<?php

namespace boundstate\eventful\translators;

use Recurr\Transformer\Translator as BaseTranslator;

class Translator extends BaseTranslator
{
    protected array $overrides = [
        'for %count% times' => '%count% times',
    ];

    public function __construct()
    {
        parent::__construct();

        $this->data = array_merge($this->data, $this->overrides);
    }
}
