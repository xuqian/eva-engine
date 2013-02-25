<?php

namespace Event\DbTable;

use Eva\Db\TableGateway\TableGateway;
use Zend\Stdlib\Parameters;

class Tags extends TableGateway
{
    protected $tableName ='tags';
    protected $primaryKey = 'id';
    
    protected $uniqueIndex = array(
        'tagName',
    );

    public function setParameters(Parameters $params)
    {
        if($params->page){
            $this->enableCount();
            $this->page($params->page);
        }

        if($params->noLimit) {
            $this->disableLimit();
        }

        if ($params->order == 'eventcountdesc' || $params->order == 'eventcountasc') {
            $eventTagTable = Api::_()->getDbTable('Event\DbTable\TagsEvents');
            $eventTagTableName = $eventTagTable->initTableName()->getTable();

            $this->join(
                $eventTagTableName,
                "id = $eventTagTableName.tag_id"
            );
            $this->columns(array(
                '*',
                'EventCount' => new Expression("count(event_id)"),
            ));
            $this->group('tag_id');
        }

        $orders = array(
            'idasc' => 'id ASC',
            'iddesc' => 'id DESC',
            'nameasc' => 'tagName ASC',
            'namedesc' => 'tagName DESC',
        );

        if($params->order){
            $order = $orders[$params->order];
            if($order){
                $this->order($order);
            }
        }

        return $this;
    }
}
