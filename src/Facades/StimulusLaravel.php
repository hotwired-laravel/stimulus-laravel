<?php

namespace HotwiredLaravel\StimulusLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \HotwiredLaravel\StimulusLaravel\StimulusLaravel
 */
class StimulusLaravel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \HotwiredLaravel\StimulusLaravel\StimulusLaravel::class;
    }
}
