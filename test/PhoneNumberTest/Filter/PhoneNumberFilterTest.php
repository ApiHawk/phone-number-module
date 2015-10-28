<?php

namespace PhoneNumberTest\Filter;

use Mockery;
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
        $values = [
            '  +41 79 800 00 00  ',
            '  +41  798000000!!',
            'xx0798000000xx',
            '798000000',
        ];
        foreach ($values as $value) {
            $phoneNumber = $this->filter->filter($value);
            $this->assertEquals('+41798000000', $phoneNumber, "Given number '$value' is not ok");
        }
    }

    /**
     * @test
     */
    public function filterInvalid()
    {
        $values = [
            null,
            'null',
            ' ',
            '  +41 79 800 00 00!!cs',
            '+17980002000',
            '07 98 000000 x2',
            '7980000002',
        ];
        foreach ($values as $value) {
            $phoneNumber = $this->filter->filter($value);
            $this->assertNotEquals('+41798000000', $phoneNumber, "Given number '$value' is not ok");
        }
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

        $serviceManager = Mockery::mock('Zend\InputFilter\InputFilterPluginManager');
        $serviceManager
            ->shouldReceive('getServiceLocator')
            ->andReturn($serviceLocator);

        return $serviceManager;
    }
}
