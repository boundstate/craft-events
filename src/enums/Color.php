<?php

namespace boundstate\eventful\enums;

enum Color: string
{
    case BEETROOT = '#b31f57';
    case TANGERINE = '#fe542f';
    case CITRON = '#e7c351';
    case BASIL = '#007f48';
    case BLUEBERRY = '#3c52b0';
    case GRAPE = '#922aa5';

    case CHERRY_BLOSSOM = '#e12661';
    case PUMPKIN = '#f86d25';
    case AVOCADO = '#bfc948';
    case EUCALYPTUS = '#009487';
    case LAVENDAR = '#7585c7';
    case COCOA = '#7b564b';

    case TOMATO = '#de141a';
    case MANGO = '#f8922c';
    case PISTACHIO = '#75b14d';
    case PEACOCK = '#0099e1';
    case WISTERIA = '#b39cd7';
    case GRAPHITE = '#616161';

    case FLAMINGO = '#ee7c75';
    case BANANA = '#fcbe41';
    case SAGE = '#00b47b';
    case COBALT = '#3084ef';
    case AMETHYST = '#a069ab';
    case BIRCH = '#a79a8e';

    /**
     * Returns the color for the given index.
     */
    public static function at(int $index): string
    {
        $values = self::values();

        return $values[$index % count($values)];
    }

    private static function values(): array
    {
        return array_column(Color::cases(), 'value');
    }
}
