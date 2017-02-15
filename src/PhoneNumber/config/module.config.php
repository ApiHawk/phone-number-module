<?php

namespace PhoneNumber;

use PhoneNumber\Delegator\ConfigInjectDelegate;

return [
    'phone_number' => [
        'default_region' => 'CH',
    ],
    'service_manager' => [
        'invokables' => [
            'PhoneNumber\Filter\PhoneNumberFilter' => 'PhoneNumber\Filter\PhoneNumberFilter',
            'PhoneNumber\Validator\PhoneNumberValidator' => 'PhoneNumber\Validator\PhoneNumberValidator',
        ],
        'factories' => [
            'libphonenumber\PhoneNumberUtil' => 'PhoneNumber\Factory\PhoneNumberUtilFactory',
        ],
        'delegators' => [
            Validator\PhoneNumberValidator::class => ConfigInjectDelegate::class,
        ],
        'shared' => [
        ],
    ],
];
