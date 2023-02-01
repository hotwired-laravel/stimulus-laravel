<?php

namespace Hotwired\StimulusLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hotwired\StimulusLaravel\StimulusLaravel
 */
class StimulusLaravel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Hotwired\StimulusLaravel\StimulusLaravel::class;
    }
}
