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

namespace Eva\Mvc\Model;


use Zend\Di\Di,
    Zend\Di\Config as DiConfig,
    Eva\Config\Config,
    Zend\Mvc\Exception\MissingLocatorException,
    Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Mvc Abstract Model for item / itemlist / paginator
 *
 * @category   Eva
 * @package    Eva_Mvc
 * @subpackage Model
 * @copyright  Copyright (c) 2012 AlloVince (http://avnpc.com/)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class AbstractModelService implements ServiceLocatorAwareInterface
{
    protected $events = array(
        'getItem.precache',
        'getItem.pre',
        'getItem',
        'getItem.post',
        'getItem.postcache',
        'getItemList.precache',
        'getItemList.pre',
        'getItemList',
        'getItemList.post',
        'getItemList.postcache',
        'createItem.pre',
        'createItem',
        'createItem.post',
        'saveItem.pre',
        'saveItem',
        'saveItem.post',
        'removeItem.pre',
        'removeItem',
        'removeItem.post',
    );


    protected $itemClass;
    protected $item;
    protected $itemList;

    protected $cacheStorageFactory;
    protected $paginator;

    /**
    * @var ServiceLocatorInterface
    */
    protected $serviceLocator;

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
        return $this->serviceLocator;
    }

    public function getEvent()
    {
    
    }


    public function getCache(array $config = array())
    {
        if($this->cacheStorageFactory){
            return $this->cacheStorageFactory;
        }

        $di = new Di();
        $diConfig = array(
            'definition' => array(
                'class' => array(
                    'Zend\Cache\Storage\Adapter' => array(
                        'instantiator' => array(
                            'Eva\Cache\StorageFactory',
                            'factory'
                        ),
                    ),
                    'Eva\Cache\StorageFactory' => array(
                        'methods' => array(
                            'factory' => array(
                                'cfg' => array(
                                    'required' => true,
                                    'type' => false
                                )
                            )
                        ),
                    ),
                ),
            ),
            'instance' => array(
                'Eva\Cache\StorageFactory' => array(
                    'parameters' => array(
                        'cfg' => array(
                            'adapter' => array(
                                'name' => 'filesystem',
                                'options' => array(
                                    'cacheDir' => EVA_ROOT_PATH . '/data/cache/model/',
                                ),
                            ),
                            'plugins' => array('serializer')
                        ),
                    )
                ),
            )
        );

        $globalConfig = $this->serviceLocator->get('Configuration');
        $globalConfig = isset($globalConfig['cache']['model']) ? $globalConfig['cache']['model'] : array();
        $diConfig = Config::mergeArray($diConfig, $globalConfig, $config);
        $di->configure(new DiConfig($diConfig));
        return $this->cacheStorageFactory = $di->get('Eva\Cache\StorageFactory');
    }

    public function getItemClass()
    {
        if($this->itemClass){
            return $this->itemClass;
        }

        $className = get_class($this);
        return $this->itemClass = $className . '\Item';
    }

    public function init()
    {
        $this->serviceLocator->setInvokableClass('ModelCache', 'Eva\Cache\Service\ModelCache');
        $itemClass = $this->getItemClass(); 
        $this->serviceLocator->setInvokableClass($itemClass, $itemClass);

    }

}
