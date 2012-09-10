<?php
namespace Epic;

use Zend\Mvc\MvcEvent;
class Module
{
    public function onBootstrap($e)
    {
        $event = $e->getApplication()->getEventManager();
        $event->attach(MvcEvent::EVENT_DISPATCH, array($this, 'autolanguage'), 1);
    }

    public function autolanguage($e)
    {
        $controller = $e->getTarget();
        $language = $controller->cookie()->read('lang');
        if($language){
            return $this;
        }

        return $this;
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
