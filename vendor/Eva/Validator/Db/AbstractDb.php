<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Validator
 */

namespace Eva\Validator\Db;

use Eva\Api,
    Zend\Validator\Exception,
    Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class for Database record validation
 *
 * @category   Zend
 * @package    Zend_Validate
 */
abstract class AbstractDb extends \Zend\Validator\Db\AbstractDb implements ServiceLocatorAwareInterface
{

    /**
    * @var ServiceLocatorInterface
    */
    protected $serviceLocator;

    protected $options;

    /**
    * Set the service locator.
    *
    * @param ServiceLocatorInterface $serviceLocator
    * @return AbstractHelper
    */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->init();
        return $this;
    }

    /**
     * Get the service locator.
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        //Use instance for temp
        return Api::_()->getServiceManager();
        //return $this->serviceLocator;
    }


    public function init()
    {
        $options = $this->options;
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('config');
        
        if(isset($config['db']['prefix'])){
            $this->setTable($config['db']['prefix'] . $this->getTable());
        }

        if(!$this->getAdapter() && $serviceLocator->has('Zend\Db\Adapter\Adapter')){
            $this->setAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'));
        }
    }
}
