<?php

namespace PhoneNumber;

use PhoneNumber\Delegator\ConfigInjectDelegate;
use PhoneNumber\Filter\PhoneNumberFilter;
use PhoneNumber\Validator\PhoneNumberValidator;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'phone_number' => [
        'default_region' => 'CH',
    ],
    'service_manager' => [
        'factories' => [
            'libphonenumber\PhoneNumberUtil' => 'PhoneNumber\Factory\PhoneNumberUtilFactory',
            PhoneNumberValidator::class      => InvokableFactory::class,
            PhoneNumberFilter::class         => InvokableFactory::class,
        ],
        'delegators' => [
            Validator\PhoneNumberValidator::class => ConfigInjectDelegate::class,
        ],
        'shared' => [
        ],
    ],
];
