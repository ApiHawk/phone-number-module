# phone-number-module

Integrates libphonenumber into your Zend Framework 2 application. Currently only a ZF2 form filter and validator has been implemented.

## Using the form filters and validators

* Activate the PhoneNumber module in your application configuration (_config/application.config.php_)

```
<?php
	return [
    	// This should be an array of module namespaces used in the application.
    	'modules' => [
        	'MyApp',
       		'PhoneNumber',
    	],
    ];

```

* If necessary override the default region in your module configuration (_config/autoload/config.local.php_). Default setting is _"CH"_ (Switzerland). See _\libphonenumber\RegionCode_ class for valid region codes.


```
<?php
	return [
    	'phone_number' => [
        	'default_region' => 'CH',
    	],
    ];
```

**Note:** The region can be overriden in the filter or validator options as well (with keyword _"region"_).


* Add the filter and validator to the form.


```
<?php

namespace Contact;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class ContactForm extends Form implements InputFilterProviderInterface
{
    public function init()
    {
        $this->add([
            'name' => 'mobile',
            'type' => 'Text',
            'options' => [
                'label' => 'Mobile *'
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            [
                'name' => 'mobile',
                'required' => true,
                'filters' => [
                    [
                    	'name' => 'PhoneNumber\Filter\PhoneNumberFilter',
                    	'options' => [
                    		 // override the default region
                            'region' => 'GB',
                        ],
                    ],
                ],
                'validators' => [
                    [
                        'name' => 'PhoneNumber\Validator\PhoneNumberValidator',
                        'options' => [
                        	 // override the default region
                            'region' => 'GB',
                            // override the error messages
                            'messageTemplates' => [
                                \PhoneNumber\Validator\PhoneNumberValidator::INVALID 
                                	=> _("'%value%' is not a valid phone number")
                            ]
                        ],
                    ],
                ],
            ],
        ];
    }
}

```


### Running unit tests locally

You have to install **PhpUnit** for running the unit tests in your local environment.

#### PhpUnit Installation directives for MacOSX

 ```
 curl https://phar.phpunit.de/phpunit.phar -o phpunit.phar
 chmod +x phpunit.phar
 sudo mv phpunit.phar /usr/local/bin/phpunit
 ```

#### Install composer.phar and vendor modules

```
$:> curl -sS https://getcomposer.org/installer | php
$:> chmod +x composer.phar
$:> ./composer.phar install
```

#### Run all unit tests

```
$:> cd test
$:> phpunit
```
