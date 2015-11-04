<?php

namespace PhoneNumber\Twig\Extension;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class PhoneNumberFormatter
 *
 * @package PhoneNumber\Twig\Extension
 */
class PhoneNumberFormatter extends \Twig_Extension implements
    ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait;

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('phone_nr_e164', [$this, 'formatE164']),
            new \Twig_SimpleFilter('phone_nr_international', [$this, 'formatInternational']),
            new \Twig_SimpleFilter('phone_nr_national', [$this, 'formatNational']),
            new \Twig_SimpleFilter('phone_nr_rfc3966', [$this, 'formatRFC3966']),
        ];
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function formatE164($value)
    {
        return $this->format($value, PhoneNumberFormat::E164);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function formatInternational($value)
    {
        return $this->format($value, PhoneNumberFormat::INTERNATIONAL);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function formatNational($value)
    {
        return $this->format($value, PhoneNumberFormat::NATIONAL);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function formatRFC3966($value)
    {
        return $this->format($value, PhoneNumberFormat::RFC3966);
    }

    /**
     * @param string  $value
     * @param integer $format
     *
     * @return string
     */
    private function format($value, $format)
    {
        $parser = $this->getParser();

        try {
            $number = $parser->parse($value, $this->getRegion());

            return $this->getParser()->format($number, $format);
        } catch (NumberParseException $e) {
            return $value;
        }
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'PhoneNumberFormatter';
    }

    /**
     * @return PhoneNumberUtil
     */
    public function getParser()
    {
        return $this->getServiceLocator()->get('libphonenumber\PhoneNumberUtil');
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        $config = $this->getServiceLocator()->get('Config');

        if (
            isset($config['phone_number']) &&
            isset($config['phone_number']['default_region'])
        ) {
            return $config['phone_number']['default_region'];
        } else {
            return 'CH';
        }
    }
}
