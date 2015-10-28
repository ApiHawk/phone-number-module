<?php

namespace PhoneNumberTest\Validator;

use Mockery;
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
        $values = [
            '  +41 79 800 00 00  ',
            '  +41  798000000!!',
            'xx0798000000xx',
            '798000000',
        ];
        foreach ($values as $number) {
            $this->assertTrue($this->validator->isValid($number));
        }
    }

    /**
     * @test
     */
    public function assertInvalid()
    {
        $values = [
            null,
            'null',
            ' ',
            '  +41 79<>800 00 00!!cs',
            ' +17 98000 2000',
            ' 07 98 000 000 -- 1',
            '7980000002',
            '+4189287',
        ];
        foreach ($values as $number) {
            $this->assertFalse($this->validator->isValid($number), "Given number '$number' should be not valid");
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
