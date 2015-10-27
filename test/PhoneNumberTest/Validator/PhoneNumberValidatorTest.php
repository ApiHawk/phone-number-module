<?php

namespace PhoneNumberTest\Validator;

use PhoneNumber\Test\Zend\ServiceManager\ServiceLocatorMock;
use PhoneNumber\Validator\PhoneNumberValidator;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhoneNumberValidatorTest extends PHPUnit_Framework_TestCase
{

    /** @var PhoneNumberValidator */
    private $validator;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->validator = new PhoneNumberValidator();
        $this->validator->setServiceLocator($this->setUpServiceLocator());

        parent::setUp();
    }

    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        $this->validator = null;
        parent::tearDown();
    }

    /**
     * @test
     */
    public function assertValid()
    {
        $number = "+41795000000";
        $this->assertTrue($this->validator->isValid($number));
    }

    /**
     * @test
     */
    public function assertInvvalid()
    {
        $number = "+417950000001";
        $this->assertFalse($this->validator->isValid($number));
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
