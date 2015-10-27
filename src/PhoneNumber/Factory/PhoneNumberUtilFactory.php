<?php

namespace PhoneNumber\Factory;

use libphonenumber\PhoneNumberUtil;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class PhoneNumberUtilFactory
 * @package PhoneNumber\Factory
 */
class PhoneNumberUtilFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return PhoneNumberUtil|mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        return $phoneNumberUtil;
    }
}
