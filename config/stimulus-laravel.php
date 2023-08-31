<?php

use HotwiredLaravel\StimulusLaravel\Features;

return [
    'controllers_path' => resource_path(join(DIRECTORY_SEPARATOR, ['js', 'controllers'])),
    'features' => [
        Features::directives(),
    ],
];
