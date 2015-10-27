<?php

namespace PhoneNumber\Filter;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;
use Zend\Filter\AbstractFilter;
use Zend\Filter\Exception;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class PhoneNumberFilter
 * @package PhoneNumber\Filter
 */
class PhoneNumberFilter extends AbstractFilter implements
    ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait;

    /**
     * Returns the result of filtering $value.
     *
     * @param mixed  $value
     * @param string $locale Defaults to module config option 'default_locale'.
     *
     * @return mixed
     * @throws Exception\RuntimeException If filtering $value is impossible.
     */
    public function filter($value, $locale = null)
    {
        $locale = isset($locale) ? $locale : $this->getDefaultLocale();
        $phoneUtil = $this->getPhoneNUmberUtil();

        $numberProto = $phoneUtil->parse($value, $locale);

        return $numberProto->__toString();
    }

    /**
     * @return PhoneNumberUtil
     */
    private function getPhoneNUmberUtil()
    {
        return PhoneNumberUtil::getInstance();
    }

    /**
     * @return string
     */
    private function getDefaultLocale()
    {
        $config = $this->getServiceLocator()->get('Config');
        if (
            isset($config) &&
            isset($config['phone_number']) &&
            isset($config['phone_number']['default_locale'])
        ) {
            return $config['phone_number']['default_locale'];
        } else {
            return 'GB';
        }
    }
}
