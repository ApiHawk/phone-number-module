<?php

namespace PhoneNumberTest\Factory;

use PhoneNumber\Factory\PhoneNumberUtilFactory;
use PhoneNumber\Test\Zend\ServiceManager\ServiceLocatorMock;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhoneNumberUtilFactoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var PhoneNumberUtilFactory
     */
    private $factory;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->factory = new PhoneNumberUtilFactory();

        parent::setUp();
    }

    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        $this->factory = null;

        parent::tearDown();
    }

    /**
     * @test
     */
    public function createService()
    {
        $serviceLocator = $this->setUpServiceLocator();

        $service = $this->factory->createService($serviceLocator);
        $this->assertInstanceOf('libphonenumber\PhoneNumberUtil', $service);
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
