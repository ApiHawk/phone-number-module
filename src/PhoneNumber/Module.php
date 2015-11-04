<?php

namespace PhoneNumber;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class Module
 * @package PhoneNumber
 */
class Module
{

    use ServiceLocatorAwareTrait;

    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $this->setServiceLocator($sm);

        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $this->initTwig();
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/config/module.config.php'
        );
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function initTwig()
    {
        /** @var \Twig_Environment $twig */
        $twig = $this->getServiceLocator()->get('Twig_Environment');
        $twig->addGlobal(
            'PhoneNumberFormatter',
            $this->getServiceLocator()->get('PhoneNumber\Twig\Extension\PhoneNumberFormatter')
        );
    }
}

