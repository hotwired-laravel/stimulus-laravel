<?php

namespace Tonysm\StimulusLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tonysm\StimulusLaravel\StimulusLaravel
 */
class StimulusLaravel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Tonysm\StimulusLaravel\StimulusLaravel::class;
    }
}
