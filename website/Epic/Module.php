<?php
namespace Epic;

use Zend\Mvc\MvcEvent;
use Epic\Exception;


class Module
{
    public function onBootstrap($e)
    {
        $event = $e->getApplication()->getEventManager();
        $event->attach(MvcEvent::EVENT_DISPATCH, array($this, 'autolanguage'), 1);
        $event->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'errorHandler'), 1);
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

    public function errorHandler($e)
    {
        $exception = $e->getParam('exception');
        $controller = $e->getTarget();
        $redirecter = '';
        if($controller instanceof \Zend\Mvc\Controller\AbstractController){
            $redirecter = $controller->getPluginManager()->get('redirect');
        }
        if($exception instanceof Exception\UnauthorizedException){
            if($redirecter){
                $e->getResponse()->setStatusCode(401);
                return $redirecter->toUrl('/login/?callback=' . $this->getCurrentUrl());
            }
        } elseif ($exception instanceof Exception\InvalidArgumentException){
            $e->getResponse()->setStatusCode(400);
        } elseif ($exception instanceof Exception\PageNotFoundException){
            $e->getResponse()->setStatusCode(404);
        }
    }

    protected function getCurrentUrl()
    {
        $pageURL = 'http';

        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on"){
            $pageURL .= "s";
        }
        $pageURL .= "://";

        if ($_SERVER["SERVER_PORT"] != "80"){
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        }
        else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
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
