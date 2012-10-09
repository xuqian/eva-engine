<?php
/**
 * EvaEngine
 *
 * @link      https://github.com/AlloVince/eva-engine
 * @copyright Copyright (c) 2012 AlloVince (http://avnpc.com/)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Eva_Api.php
 * @author    AlloVince
 */
namespace Eva;

use Zend\Di\Di,
    Zend\Di\Config as DiConfig,
    Zend\Db\Adapter\Adapter as DbAdapter,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\ModuleManager\Exception\RuntimeException;

/**
 * Singleton Pattern Api
 *
 * A handler for mvc event, service manager
 *
 * @category   Eva
 * @package    Eva_Api
 */
class Api
{
    protected static $instance;
    protected $event;
    protected $config;
    protected $appConfig;
    protected $dbAdapter;
    protected $moduleLoaded;
    protected $moduleConfig;
    protected $di;
    protected $view;

    public function setEvent($event)
    {
        $this->event = $event;
    }

    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Shorthand for getInstance
     *
     * @return Eva\Api
     */
    public static function _()
    {
        return self::getInstance();
    }

    public static function getInstance()
    {
        if( is_null(self::$instance) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Set or unset the current api instance
     * 
     * @param Eva\Api $api
     * @return Eva\Api
     */
    public static function setInstance(Api $api = null) 
    {
        return self::$instance = $api;
    }

    public function getConfig()
    {
        $event = $this->getEvent();
        $app = $event->getApplication();
        return $app->getConfig();
    }

    public function getAppConfig()
    {
        if($this->appConfig){
            return $this->appConfig;
        }

        return $this->event->getApplication()->getServiceManager()->get('ApplicationConfig');
    }


    public function getModulePath($moduleName)
    {
        $module = $this->event->getApplication()->getServiceManager()->get('modulemanager')->getModule($moduleName);
        if(!$module){
            return '';
        }

        $object = new \ReflectionObject($module);
        $modulePath = dirname($object->getFileName());
        if(!$modulePath){
            return '';
        }
        return $modulePath;
    }

    public function getModuleConfig($moduleName)
    {
        $configKey = ucfirst($moduleName);
        if(isset($this->moduleConfig[$configKey])) {
            return $this->moduleConfig[$configKey];
        }

        $modulePath = $this->getModulePath($moduleName);
        if(!$modulePath){
            return $this->moduleConfig[$configKey] = array();
        }
        $path = $modulePath . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
        $globalConfig =  $path . 'module.global.config.php';
        $localConfig = $path . 'module.local.config.php';
        if(false === file_exists($globalConfig)) {
            return $this->moduleConfig[$configKey] = array();
        }

        if(!file_exists($localConfig)){
            return $this->moduleConfig[$configKey] = include $globalConfig;
        }

        $globalConfig = new \Zend\Config\Config(include $globalConfig);
        $localConfig = new \Zend\Config\Config(include $localConfig);

        $globalConfig->merge($localConfig);
        return $this->moduleConfig[$configKey] = $globalConfig->toArray();
    }

    public function getModuleLoaded()
    {
        if($this->moduleLoaded){
            return $this->moduleLoaded;
        }
        
        $modules = $this->event->getApplication()->getServiceManager()->get('modulemanager')->getLoadedModules();
        $moduleLoaded = array_keys($modules);
        return $this->moduleLoaded = $moduleLoaded;
    }


    public function isModuleLoaded($className)
    {
        $moduleLoaded = $this->getModuleLoaded();

        $className = ltrim($className, '\\');
        $moduleName = explode('\\', $className);
        if(!$moduleName) {
            return false;
        }

        if(isset($moduleName[0]) && false === in_array($moduleName[0], $moduleLoaded)){
            return false;
        }

        return true;
    }

    public function getDi()
    {
        if($this->di){
            return $this->di;
        }


        return $this->di = new Di();
    }

    public function setDbAdapter($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        return self::$instance;
    }

    public function getDbAdapter($configKeyOrArray = 'db')
    {
        if($this->dbAdapter) {
            return $this->dbAdapter;
        }

        $dbAdapter = $this->event->getApplication()->getServiceManager()->get('Zend\Db\Adapter\Adapter');
        return $this->dbAdapter = $dbAdapter;
    }

    public function getDbTable($tableClassName)
    {
        if(false === $this->isModuleLoaded($tableClassName)){
            throw new RuntimeException(sprintf(
                'Module not loaded by class %s',
                $tableClassName
            ));    
        }

        $serviceManager = $this->event->getApplication()->getServiceManager();
        if($serviceManager->has($tableClassName)){
            return $serviceManager->get($tableClassName);
        }

        $serviceManager->setFactory($tableClassName, function(ServiceLocatorInterface $serviceLocator) use ($tableClassName){
            return new $tableClassName($serviceLocator->get('Zend\Db\Adapter\Adapter'));
        });

        return $serviceManager->get($tableClassName);
    }

    public function setRestfulResource()
    {
    }

    public function getRestfulResource()
    {
        return $this->restfulResource; 
    }

    public function getRouterMatch()
    {
        return $this->event->getRouteMatch();
    }

    public function getForm($formClassName)
    {
        if(false === $this->isModuleLoaded($formClassName)){
            throw new RuntimeException(sprintf(
                'Module not loaded by class %s',
                $formClassName
            ));    
        }

        return new $formClassName;
    }

    public function getModel($modelClassName)
    {
        if(false === $this->isModuleLoaded($modelClassName)){
            throw new RuntimeException(sprintf(
                'Module not loaded by class %s',
                $modelClassName
            ));    
        }
        
        $serviceManager = $this->event->getApplication()->getServiceManager();
        if($serviceManager->has($modelClassName)){
            return $serviceManager->get($modelClassName);
        }

        $serviceManager->setInvokableClass($modelClassName, $modelClassName);
        return $serviceManager->get($modelClassName);
    }


    public function getView()
    {
        if($this->view){
            return $this->view;
        }
        return $this->view = $this->event->getApplication()->getServiceManager()->get('ViewManager')->getRenderer();
    }

    public function getServiceManager()
    {
        return $this->event->getApplication()->getServiceManager();
    }
}
