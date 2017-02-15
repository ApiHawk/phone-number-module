<?php

namespace PhoneNumber\Validator;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

/**
 * Class PhoneNumberValidator
 * @package PhoneNumber
 */
class PhoneNumberValidator extends AbstractValidator
{
    const INVALID = 'invalid';

    /** @var array  */
    private $config = [];

    /**
     * @var string
     */
    private $region;

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID => "'%value%' is not a valid phone number"
    ];

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * Returns true if and only if $value meets the validation requirements.
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param mixed $value
     *
     * @return boolean
     * @throws Exception\RuntimeException If validation of $value is impossible.
     */
    public function isValid($value)
    {
        $region = $this->getRegion();
        $region = isset($region) ? $region : $this->getDefaultRegion();

        $this->setValue($value);
        $phoneUtil = $this->getPhoneNUmberUtil();

        try {
            $numberProto = $phoneUtil->parse($value, $region);
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
    private function getDefaultRegion()
    {
        $config = $this->getConfig();

        if (
            isset($config) &&
            isset($config['phone_number']) &&
            isset($config['phone_number']['default_region'])
        ) {
            return $config['phone_number']['default_region'];
        } else {
            return 'CH';
        }
    }

    /**
     * @return array
     */
    private function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}
