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

namespace Eva\Mvc\Item;


use Eva\Mvc\Model\AbstractModel,
    Eva\Paginator\Paginator,
    Zend\Mvc\Exception,
    Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Stdlib\Hydrator\ClassMethods;
use ArrayObject;
use ArrayIterator;
use ArrayAccess;
use Iterator;

/**
 * Mvc Abstract Model for item / itemlist / paginator
 *
 * @category   Eva
 * @package    Eva_Mvc
 * @subpackage Model
 * @copyright  Copyright (c) 2012 AlloVince (http://avnpc.com/)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class AbstractItem implements ArrayAccess, Iterator, ServiceLocatorAwareInterface
{

    const DEFAULT_COUNT_KEY = 'eva_item_count';

    /**
     * @var null|int
     */
    protected $count = null;

    /**
     * @var Eva\Mvc\Model\AbstractModel
     */
    protected $model;

    /**
     * @var Iterator|IteratorAggregate
     */
    protected $dataSource = null;

    /**
     * @var DbTable | Webservice
     */
    protected $dataSourceType = 'DbTable';

    protected $dataSourceClass = '';

    protected $relationships = array();
    
    protected $inverseRelationships = array();

    protected $initialized = false;

    /**
     * @var null
     */
    protected $objectPrototype = null;

    /**
    * @var ServiceLocatorInterface
    */
    protected $serviceLocator;

    protected $paginator;

    /**
    * Set the service locator.
    *
    * @param ServiceLocatorInterface $serviceLocator
    * @return AbstractHelper
    */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
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


    /**
     * Set the row object prototype
     *
     * @param  object $objectPrototype
     * @return ResultSet
     */
    public function setObjectPrototype($objectPrototype)
    {
        if (!is_object($objectPrototype)) {
            throw new Exception\InvalidArgumentException(
                'An object must be set as the object prototype, a ' . gettype($objectPrototype) . ' was provided.'
            );
        }
        $this->objectPrototype = $objectPrototype;
        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        if(!$model instanceof AbstractModel){
            throw new Exception\MissingLocatorException(printf('Model Service Locator not set by class %s',
            get_class($this)));
        }
        $this->model = $model;
        $this->initialize();
        return $this;
    }


    public function setPaginator($paginator)
    {
        $this->paginator = $paginator;
    }

    public function getPaginator(array $paginatorOptions = array())
    {
        $defaultPaginatorOptions = array(
            'itemCountPerPage' => 10,
            'pageRange' => 5,
            'pageNumber' => 1,
        );

        $dataClass = $this->getDataClass();
        $count = $dataClass->getCount();
        if(!$count) {
            return $this->paginator = null;
        }

        $dbPaginatorOptions = $dataClass->getPaginatorOptions();
        $paginatorOptions = array_merge($defaultPaginatorOptions, $dbPaginatorOptions, $paginatorOptions);

        $count = (int) $count;
        $diConfig = array(
            'instance' => array(
                'Zend\Paginator\Adapter\DbSelect' => array(
                    'parameters' => array(
                        'rowCount' => $count,
                        'select' => $dataClass->getSelect(),
                        'adapterOrSqlObject' => $dataClass->getSql(),
                    )
                ),
                'Eva\Paginator\Paginator' => array(
                    'parameters' => array(
                        'rowCount' => $count,
                        'adapter' => 'Zend\Paginator\Adapter\DbSelect',
                    ),
                ),
            )
        );


        foreach ($paginatorOptions as $key => $value) {
            if(false === in_array($key, array('itemCountPerPage', 'pageNumber', 'pageRange'))){
                continue;
            }
            $diConfig['instance']['Eva\Paginator\Paginator']['parameters'][$key] = $paginatorOptions[$key];
        }

        $di = new \Zend\Di\Di();
        $di->configure(new \Zend\Di\Config($diConfig));
        $paginator = $di->get('Eva\Paginator\Paginator');
        return $this->paginator = $paginator;
    }

    public function dbTable()
    {
        $tableClassName = $this->dataSourceClass;
        $serviceManager = $this->getServiceLocator();
        if($serviceManager->has($tableClassName)){
            return $serviceManager->get($tableClassName);
        }

        $serviceManager->setFactory($tableClassName, function(ServiceLocatorInterface $serviceLocator) use ($tableClassName){
            return new $tableClassName($serviceLocator->get('Zend\Db\Adapter\Adapter'));
        });

        return $serviceManager->get($tableClassName);
    }

    public function webService()
    {
    
    }

    public function getDataClass()
    {
        if($this->dataSourceType == 'WebService'){
            return $this->getWebService();
        }

        return $this->dbTable();
    }

    /**
     * Get the data source used to create the result set
     *
     * @return null|Iterator
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    public function mergeDataSource(array $dataSource)
    {
        foreach($dataSource as $key => $value){
            if($value !== null){
                $this->dataSource[$key] = $value;
            }
        }

        return $this;
    }

    public function setDataSource($dataSource)
    {
        if (is_array($dataSource)) {
            // its safe to get numbers from an array
            $first = current($dataSource);
            reset($dataSource);
            $this->count = count($dataSource);
            $this->dataSource = new ArrayIterator($dataSource);
        } elseif ($dataSource instanceof IteratorAggregate) {
            $this->dataSource = $dataSource->getIterator();
        } elseif ($dataSource instanceof Iterator) {
            $this->dataSource = $dataSource;
        } else {
            throw new Exception\InvalidArgumentException('DataSource provided is not an array, nor does it implement Iterator or IteratorAggregate');
        }
        return $this;
    }

    public function clear()
    {
        $this->setDataSource(array());
        return $this;
    }

    public function hasLoadedRelationships()
    {
        $hasRelationships = false;
        foreach($this->relationships as $key => $relationship){
            if(isset($relationship['dataSource']) && $relationship['dataSource']){
                $hasRelationships = true;
                break;
            }
        }
        return $hasRelationships;
    }

    public function hasRelationship($key)
    {
        if(isset($this->relationships[$key]) && is_array($this->relationships[$key])){
            return true;
        }
        return false;
    }


    public function hasInverseRelationship($key)
    {
        if(isset($this->inverseRelationships[$key]) && is_array($this->inverseRelationships[$key])){
            return true;
        }
        return false;
    }


    public function getRelationship($key)
    {
        if(isset($this->relationships[$key]) && is_array($this->relationships[$key]) && $this->relationships[$key]){
            return $this->relationships[$key];
        }
        return array(); 
    }

    public function getInverseRelationship($key)
    {
        if(isset($this->inverseRelationships[$key]) && is_array($this->inverseRelationships[$key]) && $this->inverseRelationships[$key]){
            return $this->inverseRelationships[$key];
        }
        return array(); 
    }

    public function getRelationships()
    {
        return $this->relationships;
    }

    public function getLoadedRelationships()
    {
        $relationships = new ArrayObject();

        $model = $this->getModel();
        foreach($this->relationships as $key => $relationship){
            if(isset($relationship['dataSource']) && $relationship['dataSource'] && isset($relationship['targetEntity']) && $relationship['targetEntity']){
                $relItem = $this->join($key);

                if(isset($relationship['dataSource'][0])){
                    //Join Many use Set because may be join items total number change
                    $relItem->setDataSource($relationship['dataSource']);
                } else {
                    //Join OneToOne use merge to passing referenced id
                    $relItem->mergeDataSource($relationship['dataSource']);
                }
                $relationships[$key] = $relItem;
            }
        }
        return $relationships;
    }

    public function addRelationship($key, array $relationship)
    {
        if(isset($this->relationships[$key])){
        //    throw new Exception\InvalidArgumentException(sprintf('Relationship %s already exists in %, failed to add same one.', $key, get_class($this)));
        }

        $this->relationships[$key] = $relationship;
        return $this;
    }

    public function removeRelationship($key)
    {
        if(isset($this->relationships[$key])){
            unset($this->relationships[$key]);
        }
        return $this;
    }


    /**
    * Cast result set to array of arrays
    *
    * @return array
    * @throws Exception\RuntimeException if any row is not castable to an array
    */
    public function toArray(array $map = array())
    {
        if(0 === count($this->dataSource)){
            return array();
        }

        if(isset($this->dataSource[0])){
            foreach($this->dataSource as $key => $subDataSource){
                if(method_exists($subDataSource, 'toArray')){
                    $this->dataSource[$key] = $subDataSource->toArray($map);
                }
            }
            return $this->singleToArray(array());
        } else {
            return $this->singleToArray($map);
        }
    }

    public function getArrayCopy()
    {
        return $this->toArray();
    }

    protected function singleToArray($map)
    {
        if($map){
            if(is_array(current($map))){
                $self = isset($map['self']) ? $map['self'] : array();
                $join = isset($map['join']) ? $map['join'] : array();
                $proxy = isset($map['proxy']) ? $map['proxy'] : array();
                $return = $this->dump($self, $join, $proxy);
            } else {
                $this->self($map);
            }
        }

        $return = $this->arrayAccessToArray($this->dataSource);
        return $return;
    }

    protected function arrayAccessToArray($arr)
    {
        $arr = (array) $arr;
        foreach($arr as $key => $value){
            if(is_object($value)){
                $value = (array) $value;
            } 
            $arr[$key] = $value;
        }
        return $arr;
    }

    protected function dump(array $self, array $join, array $proxy)
    {
        $self = $this->self($self);

        //If item complete empty will not join
        if(0 === count($self->dataSource)){
            return $self;
        }

        foreach($proxy as $key => $map){
            list($moduleItemClass, $relationshipKey) = explode('::', $key);
            $modulesLoaded = $this->serviceLocator->get('modulemanager')->getLoadedModules();
            $module = explode('\\', $moduleItemClass);
            $module = array_shift($module);
            if(!isset($modulesLoaded[$module])){
                continue;
            }

            $proxyItem = $this->model->getItem($moduleItemClass);
            if($proxyItem->hasInverseRelationship($relationshipKey)){
                $relationshipArray = $proxyItem->getInverseRelationship($relationshipKey);
                $this->addRelationship($relationshipKey, $relationshipArray);
                $join[$relationshipKey] = $map;
            }
        }

        foreach($join as $key => $map){
            if(!isset($this->relationships[$key])){
                continue;
            }

            $relationship = $this->relationships[$key];
            $joinedItem = $this->join($key);

            //Insert manytomany join middle item to parent level
            if(isset($relationship['inversedMappedBy'])){
                $mapKey = $relationship['inversedMappedBy'];
                $middleItems = array();
                foreach($joinedItem as $key => $item){
                    $item = $item->$mapKey;
                    if($item && method_exists($item, 'toArray')){
                        $item = $item->toArray();
                        $middleItems[$key] = $item;
                        $joinedItem[$key][$mapKey] = $item;
                    }
                }
                $self->$mapKey = $middleItems;
            }

            $joinedArray = $joinedItem->toArray($map);
            if(isset($relationship['mappedBy'])){
                $mapKey = $relationship['mappedBy'];
                $self->$mapKey = $joinedArray;
            } else {
                $self->$key = $joinedArray;
            }
        }

        return $self;
    }

    public function dataCount($params = null, $countKey = self::DEFAULT_COUNT_KEY)
    {
        $dataClass = $this->getDataClass();
        $this->clear();
        if($params && method_exists($dataClass, 'setParameters')){
            if(is_array($params)){
                $params = new \Zend\Stdlib\Parameters($params);
            } elseif($params instanceof \Zend\Stdlib\Parameters){
                $params = $params;
            } else {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Item collection require array or Zend\Stdlib\Parameters input'
                ));
            }
            $dataClass->setParameters($params);
        }

        $this->$countKey = $dataClass->find('count');
        return $this;
    }

    public function collections($params = null)
    {
        $dataClass = $this->getDataClass();
        $this->clear();
        if($params && method_exists($dataClass, 'setParameters')){
            if(is_array($params)){
                $params = new \Zend\Stdlib\Parameters($params);
            } elseif($params instanceof \Zend\Stdlib\Parameters){
                $params = $params;
            } else {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Item collection require array or Zend\Stdlib\Parameters input'
                ));
            }
            $dataClass->setParameters($params);
        }

        $items = $dataClass->find('all');

        if(!$items){
            $this->clear();
        } else {
            foreach($items as $key => $dataSource){
                $item = clone $this;
                $item->setDataSource((array) $dataSource);
                $this->dataSource[] = $item;
            }
        }
        return $this;
    }


    public function self(array $map = array())
    {
        $columns = array();
        $functions = array();
        $selectAll = false;

        if(!$map){
            return $this;
        }

        if($map && in_array('*', $map)){
            $selectAll = true;
            if($map) {
                unset($map[array_search('*', $map)]);
            }
        }

        foreach($map as $key => $value){
            if(false === strrpos($value, '()')){
                $columns[] = $value;
            } else {
                $functions[] = str_replace('()', '', $value);
            }
        } 

        $dataSource = array();
        if(true === $selectAll || $columns){
            $dataClass = $this->getDataClass();
            if(false === $selectAll){
                $dataClass->columns($columns);
            }
            $where = $this->autoDetectWhere();
            $dataSource = $dataClass->where($where)->find('one');

            //Not find in DB
            if(!$dataSource){
                $this->clear();
                return $this;
            }
        }


        //Merge to original DataSource
        $originalDataSource = $this->getDataSource();
        if($dataSource){
            foreach($dataSource as $key => $value){
                if($value === null){
                    $originalDataSource[$key] = null;
                } else {
                    $originalDataSource[$key] = $value;            
                }
            }
        }
        $dataSource = $originalDataSource;


        if(!$dataSource){
            $this->clear();
        } else {
            $this->setDataSource((array) $dataSource);
        }

        //Auto complete
        if($functions){
            foreach($functions as $key => $function){
                if(true === method_exists($this, $function)){
                    $this->$function();
                }
            }
        }

        return $this;
    }


    public function selfExist()
    {
        $dataClass = $this->getDataClass();
        $columns = array_keys($this->autoDetectWhere());
        $dataClass->columns($columns);
        $where = $this->autoDetectWhere();
        $dataSource = $dataClass->where($where)->find('one');

        //Not find in DB
        if(!$dataSource){
            return false;
        }
        return true;
    }

    public function join($key)
    { 
        $model = $this->getModel();
        if(!isset($this->relationships[$key]) || !$this->relationships[$key]){
            return new ArrayObject();
        }

        $relationship = $this->relationships[$key];

        //Important : here must use clone to create many entities
        $relItem = clone $model->getItem($relationship['targetEntity']); 
        //Important : Joined item should have no dataSource
        $relItem->clear();

        $joinFuncName = 'join' . ucfirst($key);
        if(method_exists($this, $joinFuncName)){
            $this->$joinFuncName($relItem);
        } else {
            $joinFuncName = 'join' . $relationship['relationship'];

            if(!method_exists($this, $joinFuncName)){
                throw new Exception\InvalidArgumentException(printf(
                    'Undefined relationship when join %s in class %s',
                    $key,
                    get_class($this)
                ));
            }
            $this->$joinFuncName($key, $relItem, $relationship);
        }
        return $relItem;
    }

    protected function joinOneToOne($key, $relItem, $relationship)
    {
        if(!isset($relationship['joinColumn'])){
            throw new Exception\InvalidArgumentException(sprintf(
                'Undefined join column when join %s and %s',
                get_class($this),
                get_class($relItem)
            ));
        }
        $joinColumn = $relationship['joinColumn'];
        $referencedColumn = $relationship['referencedColumn'];
        if($this->$referencedColumn) {
            $relItem->$joinColumn = $this->$referencedColumn;
        }
        //p(sprintf('%s joinOneToOne with %s : joinColumn %s => %s joined %s => %s', get_class($this), get_class($relItem), $joinColumn, $relItem->$joinColumn , $referencedColumn, $this->$referencedColumn));
        return $this;
    }

    protected function joinOneToMany($key, $relItem, $relationship)
    {
        $joinColumn = $relationship['joinColumn'];
        $referencedColumn = $relationship['referencedColumn'];
        $params = array(
            $joinColumn => $this->$referencedColumn,
        );

        if(isset($relationship['joinParameters']) && is_array($relationship['joinParameters'])){
            $params = array_merge($params, $relationship['joinParameters']);
        }

        //p(sprintf('joinOneToMany Joined Class %s : joinColumn %s => %s joined %s => %s', get_class($relItem), $joinColumn, $relItem->$joinColumn , $referencedColumn, $this->$referencedColumn));
        if(isset($relationship['asCount']) && $relationship['asCount']){
            $countKey = self::DEFAULT_COUNT_KEY;
            if(isset($relationship['countKey']) && $relationship['countKey']){
                $countKey = $relationship['countKey'];
            }
            return $relItem->dataCount($params, $countKey);
        } else {
            return $relItem->collections($params);
        }
    }

    protected function joinManyToOne($key, $relItem, $relationship)
    {
        $joinColumn = $relationship['joinColumn'];
        $referencedColumn = $relationship['referencedColumn'];
        if($this->$referencedColumn) {
            $relItem->$joinColumn = $this->$referencedColumn;
        }
        //p(sprintf('joinManyToOne Joined Class %s : joinColumn %s => %s joined %s => %s', get_class($relItem), $joinColumn, $relItem->$joinColumn , $referencedColumn, $this->$referencedColumn));
        return $this;
    }

    protected function joinManyToMany($key, $relItem, $relationship)
    {
        $joinLeftColumn = $relationship['joinColumns']['joinColumn'];
        $referencedLeftColumn = $relationship['joinColumns']['referencedColumn'];

        $middleItem = clone $relItem->model->getItem($relationship['inversedBy']); 
        $middleItem->clear();
        $params = array(
            $joinLeftColumn => $this->$referencedLeftColumn
        );
        if(isset($relationship['joinColumns']['joinParameters']) && is_array($relationship['joinColumns']['joinParameters'])){
            $params = array_merge($params, $relationship['joinColumns']['joinParameters']);
        }
        $middleItems = $middleItem->collections($params);

        $joinRightColumn = $relationship['inverseJoinColumns']['joinColumn'];
        $referencedRightColumn = $relationship['inverseJoinColumns']['referencedColumn'];

        foreach($middleItems as $middleItem){
            $rightItem = clone $relItem;
            $rightItem->clear();
            $rightItem->$referencedRightColumn = $middleItem->$joinRightColumn;

            $inversedMapKey = isset($relationship['inversedMappedBy']) ? $relationship['inversedMappedBy'] : get_class($middleItem);
            $rightItem->$inversedMapKey = $middleItem; 
            $relItem[] = $rightItem;
        }

        /*
        p(@sprintf('joinManyToMany %s :: %s <=> %s :: %s :: %s <=> %s :: %s', 
            get_class($relItem), //left table
            $referencedLeftColumn, //middle left column
            $joinLeftColumn,  //left column
            get_class($middleItem), //middle table
            $joinRightColumn, //middle right column
            $referencedRightColumn, //right column
            get_class($rightItem)
        ));
        */
        return $relItem;
    }

    public function proxy($key)
    {
        list($moduleItemClass, $relationshipKey) = explode('::', $key);
        $modulesLoaded = $this->serviceLocator->get('modulemanager')->getLoadedModules();
        $module = array_shift(explode('\\', $moduleItemClass));
        if(!isset($modulesLoaded[$module])){
            return new ArrayObject();
        }

        $proxyItem = $this->model->getItem($moduleItemClass);
        if($proxyItem->hasInverseRelationship($relationshipKey)){
            $this->addRelationship($relationshipKey, $proxyItem->getInverseRelationship($relationshipKey));
        }

        return $this->join($relationshipKey);
    }

    public function create($mapKey = 'create')
    {
        $dataClass = $this->getDataClass();
        $data = $this->toArray(
            isset($this->map[$mapKey]) ? $this->map[$mapKey] : array()
        );
        $primaryKey = $dataClass->getPrimaryKey();
        if($dataClass->create($data)){
            if(is_string($primaryKey)){
                $this->$primaryKey = $dataClass->getLastInsertValue();
            }
        }
        
        if(is_string($primaryKey)){
            return $this->$primaryKey;
        }
    }

    public function save($mapKey = 'save')
    {
        $dataClass = $this->getDataClass();
        $data = $this->toArray(
            isset($this->map[$mapKey]) ? $this->map[$mapKey] : array()
        );
        $where = $this->primaryWhere();
        $dataClass->where($where)->save($data);
        return true;
    }

    public function remove()
    {
        $dataClass = $this->getDataClass();
        $where = $this->primaryWhere();
        $dataClass->where($where)->remove();
        return true;
    }

    public function fill(AbstractItem $fillItemList, $fillByName, array $keyMap)
    {
        if(!$this->dataSource || !$fillItemList->getDataSource()){
            return $this;
        }

        if(!isset($this[0])){
            throw new Exception\InvalidArgumentException(sprintf(
                '%s must be a item list', get_class($this)
            ));
        }

        if(!isset($fillItemList[0])){
            throw new Exception\InvalidArgumentException(sprintf(
                'Filled item %s must be a list', get_class($fillItemList)
            ));
        }


        list($primaryKey) = array_keys($keyMap);
        list($foreignKey) = array_values($keyMap);

        foreach($this as $key => $item){
            foreach($fillItemList as $fillItem){
                if($item->$primaryKey == $fillItem->$foreignKey) {
                    $this[$key][$fillByName] = $fillItem;
                }
            }
        }

        return $this;
    }

    protected function autoDetectWhere()
    {
        $where = $this->primaryWhere();
        if($where){
            return $where;
        }

        $where = $this->uniqueWhere();
        if(!$where){
            throw new Exception\InvalidArgumentException(sprintf('Primary Key not set in item %s', get_class($this)));
        }
        return $where;
    }

    protected function uniqueWhere()
    {
        $dataClass = $this->getDataClass();
        $uniqueIndex = $dataClass->getUniqueIndex();
        if(!$uniqueIndex){
            return array();
        }

        $where = array();
        foreach($uniqueIndex as $uniqueIndexKey){
            if(is_array($uniqueIndexKey)){
                $multiWhere = array();
                foreach($uniqueIndexKey as $multiIndexKey){
                    if($this->$multiIndexKey){
                        $multiWhere[$multiIndexKey] = $this->$multiIndexKey;
                    }
                    if(count($multiWhere) === count($uniqueIndexKey)){
                        $where = $multiWhere;
                        break;
                    }
                }
            } elseif(is_string($uniqueIndexKey)){
                if($this->$uniqueIndexKey){
                    $where = array($uniqueIndexKey => $this->$uniqueIndexKey);
                    break;
                }
            } else {
                throw new Exception\InvalidArgumentException(sprintf('Unique Index require string or array in item %s', get_class($this)));
            }
        }
        return $where;
    }

    protected function primaryWhere()
    {
        $dataClass = $this->getDataClass();
        $primaryKey = $dataClass->getPrimaryKey();
        $where = array();

        if(is_string($primaryKey)){
            if(!$this->$primaryKey){
                return $where;
            }
            $where = array($primaryKey => $this->$primaryKey);
        } elseif(is_array($primaryKey)) {
            $multiWhere = array();
            foreach($primaryKey as $key){
                if($this->$key){
                    $multiWhere[$key] = $this->$key;
                }
            }
            if(count($primaryKey) === count($multiWhere)){
                $where = $multiWhere;
            }
        } else {
            throw new Exception\InvalidArgumentException(sprintf('Primary Key not found or not correct in class %s', get_class($dataClass)));
        }
        return $where;
    }


    public function initialize()
    {
        if(true === $this->initialized){
            return $this;
        }

        $dataSource = $this->dataSource;

        //Auto set datasource from model if they are connected
        if(!$dataSource && $this->model && $this->model->getItemClass() == get_class($this)){
            $dataSource = $this->model->getDataSource();
        }

        if($dataSource){
            foreach($dataSource as $key => $data){
                if(is_array($data)){
                    $this->relationships[$key]['dataSource'] = $data;
                    unset($dataSource[$key]);
                }
            }
        }

        if(!$dataSource){
            $dataSource = array();
        }

        $this->setDataSource($dataSource);

        $this->initialized = true;
        return $this;
    }


    public function __get($name) 
    {
        if(isset($this->dataSource[$name])){
            return $this->dataSource[$name];
        }
        return null;
    }

    public function __set($name, $value)
    {
        $this->dataSource[$name] = $value;
        return $this;
    }

    /**
    * Iterator: move pointer to next item
    *
    * @return void
    */
    public function next()
    {
        $this->dataSource->next();
    }

    /**
    * Iterator: retrieve current key
    *
    * @return mixed
    */
    public function key()
    {
        return $this->dataSource->key();
    }

    /**
    * Iterator: get current item
    *
    * @return array
    */
    public function current()
    {
        return $this->dataSource->current();
    }

    /**
    * Iterator: is pointer valid?
    *
    * @return bool
    */
    public function valid()
    {
        return $this->dataSource->valid();
    }

    /**
    * Iterator: rewind
    *
    * @return void
    */
    public function rewind()
    {
        $this->dataSource->rewind();
        // return void
    }

    /**
     * Countable: return count of rows
     *
     * @return int
     */
    public function count()
    {
        if ($this->count !== null) {
            return $this->count;
        }
        $this->count = count($this->dataSource);
        return $this->count;
    }

    public function offsetExists($index) {
        return isset($this->dataSource[$index]);
    }
 
    public function offsetGet($index) {
        if($this->offsetExists($index)) {
            return $this->dataSource[$index];
        }
        return false;
    }
 
    public function offsetSet($index, $value) {
        if($index) {
            $this->dataSource[$index] = $value;
        } else {
            $this->dataSource[] = $value;
        }
        return true;
 
    }
 
    public function offsetUnset($index) {
        unset($this->dataSource[$index]);
        return true;
    }
}
