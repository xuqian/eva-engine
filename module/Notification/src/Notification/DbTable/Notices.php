<?php

namespace Notification\DbTable;

use Eva\Db\TableGateway\TableGateway;
use Zend\Stdlib\Parameters;

class Notices extends TableGateway
{
    protected $tableName = 'notices';
    protected $primaryKey = array('user_id', 'message_id');

    public function setParameters(Parameters $params)
    {
        parent::setParameter($params);
        return $this;
    }
}
