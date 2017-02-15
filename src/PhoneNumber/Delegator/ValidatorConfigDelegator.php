<?php

namespace PhoneNumber\Delegator;

/**
 * Created by IntelliJ IDEA.
 * User: nikolayyotsov
 * Date: 2/15/17
 * Time: 2:23 PM
 */
class ValidatorConfigDelegator implements \Zend\ServiceManager\Factory\DelegatorFactoryInterface
{
    public function __invoke(
        \Interop\Container\ContainerInterface $container,
        $name,
        callable $callback,
        array $options = null
    ) {
        return method_exists($callback, 'setConfig') ? $callback->setConfig($container->get('Config')) : $callback;
    }
}
