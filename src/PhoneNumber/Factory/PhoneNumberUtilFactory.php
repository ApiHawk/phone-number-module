<?php

namespace PhoneNumber\Factory;

use Interop\Container\ContainerInterface;
use libphonenumber\PhoneNumberUtil;
use Zend\ServiceManager\Factory\FactoryInterface;


/**
 * Class PhoneNumberUtilFactory
 * @package PhoneNumber\Factory
 */
class PhoneNumberUtilFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        return $phoneNumberUtil;
    }
}
