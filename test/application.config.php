<?php

return [
    'modules' => [
        'PhoneNumber',
    ],
    'module_listener_options' => [
        'module_paths' => [
            __DIR__ . '/../vendor',
            __DIR__ . '/../src/PhoneNumber',
        ]
    ],
];
