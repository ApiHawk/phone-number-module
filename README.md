# phone-number-module

Integrates libphonenumber into your Zend Framework 2 application.

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
