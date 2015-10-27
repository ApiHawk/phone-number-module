<?php

namespace PhoneNumberTest\Filter;

use PhoneNumber\Filter\PhoneNumberFilter;
use PhoneNumber\Test\Zend\ServiceManager\ServiceLocatorMock;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhoneNumberFilterTest extends PHPUnit_Framework_TestCase
{

    /** @var PhoneNumberFilter */
    private $filter;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->filter = new PhoneNumberFilter();
        $this->filter->setServiceLocator($this->setUpServiceLocator());

        parent::setUp();
    }

    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        $this->filter = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function filterValidNumber()
    {
        $value = '+41798000000';
        $phoneNumber = $this->filter->filter($value);
        $this->assertEquals('Country Code: 41 National Number: 798000000 Country Code Source: ', $phoneNumber);
    }

    /**
     * @test
     * @expectedException \libphonenumber\NumberParseException
     */
    public function filterInvalid()
    {
        $value = null;
        $phoneNumber = $this->filter->filter($value);
        $this->assertEquals('Country Code: 41 National Number:  Country Code Source: ', $phoneNumber);
    }

    /**
     * @return ServiceLocatorInterface
     */
    private function setUpServiceLocator()
    {
        $config = [
            'phone_number' => [
                'default_locale' => 'CH'
            ]
        ];
        $serviceLocator = ServiceLocatorMock::get([
            'Config' => $config,
        ]);

        return $serviceLocator;
    }
}
