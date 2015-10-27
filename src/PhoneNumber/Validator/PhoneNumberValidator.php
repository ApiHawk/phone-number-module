<?php

namespace PhoneNumber\Validator;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Zend\Di\ServiceLocator;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Validator\AbstractValidator;

/**
 * Class PhoneNumberValidator
 * @package PhoneNumber
 */
class PhoneNumberValidator extends AbstractValidator implements
    ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait;

    const INVALID = 'invalid';

    protected $messageTemplates = [
        self::INVALID => "'%value%' is not a valid phone number"
    ];

    /**
     * @param mixed  $value
     * @param string $locale Defaults to module config option 'default_locale'.
     *
     * @return boolean
     */
    public function isValid($value, $locale = null)
    {
        $locale = isset($locale) ? $locale : $this->getDefaultLocale();

        $this->setValue($value);
        $phoneUtil = $this->getPhoneNUmberUtil();

        try {
            $numberProto = $phoneUtil->parse($value, $locale);
        } catch (NumberParseException $e) {
            $this->error(self::INVALID);
            return false;
        }

        if (!$phoneUtil->isValidNumber($numberProto)) {
            $this->error(self::INVALID);
            return false;
        }

        return true;
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
