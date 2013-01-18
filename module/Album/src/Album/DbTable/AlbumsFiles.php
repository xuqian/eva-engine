<?php

namespace Album\DbTable;

use Eva\Db\TableGateway\TableGateway;
use Zend\Stdlib\Parameters;

class AlbumsFiles extends TableGateway
{
    protected $tableName = 'albums_files';

    protected $primaryKey = array(
        'album_id',
        'file_id',
    );
    
    protected $uniqueIndex = array(
        array(
            'album_id',
            'file_id',
        ),
    );

    public function setParameters(Parameters $params)
    {
        if($params->noLimit) {
            $this->disableLimit();
        }
        
        if($params->album_id){
            $this->where(array('album_id' => $params->album_id));
        }

        if($params->file_id){
            $this->where(array('file_id' => $params->file_id));
        }
        
        if($params->page){
            $this->enableCount();
            $this->page($params->page);
        }

        if ($params->rows) {
            $this->limit((int) $params->rows);
        }

        return $this;
    }
}
