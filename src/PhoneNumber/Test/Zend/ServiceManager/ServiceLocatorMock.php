<?php

namespace PhoneNumber\Test\Zend\ServiceManager;

use Mockery;
use Mockery\Exception;
use Mockery\MockInterface;

class ServiceLocatorMock
{

    protected static $services = [];

    /**
     * @param array $services
     *
     * @return MockInterface
     * @throws Exception
     */
    public static function get(array $services)
    {
        if (is_array($services)) {
            self::$services = $services;
        }

        $mock
            = Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface')
            ->shouldReceive('get')
            ->andReturnUsing(
                function ($serviceName) {
                    if (!isset(self::$services[$serviceName])) {
                        throw new Exception(
                            "The service " . $serviceName . " is not registered in service locator mock."
                        );
                    }

                    return self::$services[$serviceName];
                }
            )
            ->getMock();

        $mock
            ->shouldReceive('set')
            ->andReturn($mock);

        return $mock;
    }
}
