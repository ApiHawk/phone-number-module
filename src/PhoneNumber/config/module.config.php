<?php

namespace PhoneNumber;

return [
    'phone_number' => [
        'default_region' => 'CH',
    ],
    'zfctwig' => [
        'extensions' => [
            'PhoneNumberFormatter' => 'PhoneNumber\Twig\Extension\PhoneNumberFormatter',
        ]
    ],
    'service_manager' => [
        'invokables' => [
            'PhoneNumber\Filter\PhoneNumberFilter' => 'PhoneNumber\Filter\PhoneNumberFilter',
            'PhoneNumber\Validator\PhoneNumberValidator' => 'PhoneNumber\Validator\PhoneNumberValidator',
            'PhoneNumber\Twig\Extension\PhoneNumberFormatter' => 'PhoneNumber\Twig\Extension\PhoneNumberFormatter',
        ],
        'factories' => [
            'libphonenumber\PhoneNumberUtil' => 'PhoneNumber\Factory\PhoneNumberUtilFactory',
        ],
        'shared' => [
        ],
    ],
];
