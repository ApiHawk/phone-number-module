<?php

return [
    'phone_number' => [
        'default_locale' => 'GB',
    ],
    'service_manager' => [
        'invokables' => [
            'PhoneNumber\Filter\PhoneNumberFilter' => 'PhoneNumber\Filter\PhoneNumberFilter',
            'PhoneNumber\Validator\PhoneNumberValidator' => 'PhoneNumber\Validator\PhoneNumberValidator',
        ],
        'factories' => [
            'libphonenumber\PhoneNumberUtil' => 'PhoneNumber\Factory\PhoneNumberUtilFactory',
        ],
        'shared' => [
        ],
    ],
];
