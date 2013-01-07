<?php

namespace User\DbTable;

use Eva\Db\TableGateway\TableGateway;
use Zend\Stdlib\Parameters;

class ImagesUsers extends TableGateway
{
    protected $tableName ='images_users';
    protected $primaryKey = array(
        'user_id',
        'file_id',
    );

    public function setParameters(Parameters $params)
    {
        if($params->user_id){
            $this->where(array('user_id' => $params->user_id));
        }

        if($params->file_id){
            $this->where(array('file_id' => $params->file_id));
        }

        if($params->usage){
            $this->where(array('usage' => $params->usage));
        }

        return $this;
    }
}
