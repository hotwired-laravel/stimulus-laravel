<?php

namespace Tonysm\StimulusLaravel;

class Features
{
    public static function directives()
    {
        return 'directives';
    }

    public static function enabled(string $feature): bool
    {
        return in_array($feature, config('stimulus-laravel.features', []));
    }
}
