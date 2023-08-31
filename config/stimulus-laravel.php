<?php

use HotwiredLaravel\StimulusLaravel\Features;

return [
    'controllers_path' => resource_path(implode(DIRECTORY_SEPARATOR, ['js', 'controllers'])),
    'features' => [
        Features::directives(),
    ],
];
