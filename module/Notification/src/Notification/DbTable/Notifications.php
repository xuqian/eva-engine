<?php

namespace Notification\DbTable;

use Eva\Db\TableGateway\TableGateway;
use Zend\Stdlib\Parameters;

class Notifications extends TableGateway
{
    protected $tableName = 'notifications';
    protected $primaryKey = 'id';
    protected $uniqueIndex = array(
        'notificationKey',
    );

    public function setParameters(Parameters $params)
    {
        parent::setParameter($params);
        return $this;
    }
}
