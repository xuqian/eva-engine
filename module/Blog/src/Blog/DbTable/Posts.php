<?php

namespace Blog\DbTable;

use Eva\Db\TableGateway\TableGateway;

class Posts extends TableGateway
{
    protected $tableName ='posts';
    protected $primaryKey = 'id';


    public function selectPosts(\Zend\Stdlib\Parameters $params)
    {
        if($params->enableCount){
            $this->enableCount();
        }

        if($params->keyword){
            $keyword = $params->keyword;
            $this->where(function($where) use ($keyword){
                $where->like('title', "%$keyword%");
                return $where;
            });
        }

        if($params->status){
            $this->where(array('status' => $params->status));
        }

        if($params->visibility){
            $this->where(array('visibility' => $params->visibility));
        }

        if($params->page){
            $this->page($params->page);
        }

        $orders = array(
            'idasc' => 'id ASC',
            'iddesc' => 'id DESC',
            'timeasc' => 'updateTime ASC',
            'timedesc' => 'updateTime DESC',
            'titleasc' => 'title ASC',
            'titledesc' => 'title DESC',
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
