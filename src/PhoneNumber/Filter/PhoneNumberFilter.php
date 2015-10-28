<?php

namespace PhoneNumber\Filter;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Traversable;
use Zend\Filter\AbstractFilter;
use Zend\Filter\Exception;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Stdlib\ArrayUtils;

/**
 * Class PhoneNumberFilter
 *
 * @package PhoneNumber\Filter
 */
class PhoneNumberFilter extends AbstractFilter implements
    ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait;

    /**
     * @var string
     */
    private $region;

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * Sets the filter options.
     *
     * Allowed options are:
     *  'region'    => The region code used for parsing the number
     *
     * @param string|array|Traversable $options
     */
    public function __construct($options = null)
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }

        if (is_array($options) && !empty($options)) {
            if (isset($options['region'])) {
                $this->setRegion($options['region']);
            }
        }
    }

    /**
     * Returns the result of filtering $value.
     *
     * @param mixed $value
     *
     * @return mixed
     * @throws Exception\RuntimeException If filtering $value is impossible.
     */
    public function filter($value)
    {
        $region = $this->getRegion();
        $region = isset($region) ? $region : $this->getDefaultRegion();

        $phoneUtil = $this->getPhoneNUmberUtil();

        try {
            $numberProto = $phoneUtil->parse($value, $region);
        } catch (NumberParseException $e) {
            return $value;
        }

        return $phoneUtil->format($numberProto, PhoneNumberFormat::E164);
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
        return $this->getServiceLocator()->getServiceLocator()->get('Config');
    }
}
