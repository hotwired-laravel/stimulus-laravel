<?php

use Hotwired\StimulusLaravel\Features;

return [
    'controllers_path' => resource_path('js/controllers'),
    'features' => [
        Features::directives(),
    ],
];
