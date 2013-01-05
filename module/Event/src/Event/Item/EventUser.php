<?php

namespace Event\Item;

use Eva\Mvc\Item\AbstractItem;

class EventUser extends AbstractItem
{
    protected $dataSourceClass = 'Event\DbTable\EventsUsers';
    
    protected $inverseRelationships = array(
        'EventCount' => array(
            'targetEntity' => 'Event\Item\EventUser',
            'relationship' => 'OneToMany',
            'joinColumn' => 'user_id',
            'referencedColumn' => 'id',
            'asCount' => true,
            'countKey' => 'eventCount',
            'joinParameters' => array(
                'count' => true,
            ),
        ),
    );

    protected $relationships = array(
        'Event' => array(
            'targetEntity' => 'Event\Item\Event',
            'relationship' => 'OneToOne',
            'joinColumn' => 'id',
            'referencedColumn' => 'event_id',
        ),
        'User' => array(
            'targetEntity' => 'User\Item\User',
            'relationship' => 'OneToOne',
            'joinColumn' => 'id',
            'referencedColumn' => 'user_id',
        ),
    );
    
    protected $map = array(
        'create' => array(
            'getRequestTime()',
            'getApprovalTime()',
        ),
        'createAdmin' => array(
            'getAdminValues()',
            'getRequestTime()',
            'getApprovalTime()',
        ),
    );

    public function getAdminValues()
    {
        $this->role          = 'admin';
        $this->operator_id   = $this->user_id;
        $this->requestStatus = 'active';
    }

    public function getRequestTime()
    {
        if(!$this->requestTime) {
            return $this->requestTime = \Eva\Date\Date::getNow();
        }
    }

    public function getApprovalTime()
    {
        if(!$this->approvalTime) {
            return $this->approvalTime = \Eva\Date\Date::getNow();
        }
    }   
}
