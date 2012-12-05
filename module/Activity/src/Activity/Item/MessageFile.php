<?php

namespace Activity\Item;

use Eva\Mvc\Item\AbstractItem;

class MessageFile extends AbstractItem
{
    protected $dataSourceClass = 'Activity\DbTable\MessagesFiles';

    protected $map = array(
        'create' => array(
        ),
    );

    public function create($mapKey = 'create')
    {
        $messageItem = $this->getModel()->getItem();
        $messageId = $messageItem->id;
        if(!$messageId || !$this->file_id) {
            return;
        }

        $data = $this->toArray();
        $data['message_id'] = $messageId;
        $dataClass = $this->getDataClass();
        $dataClass->create($data);
    }

    public function save($mapKey = 'save')
    {
        $messageItem = $this->getModel()->getItem();
        $messageId = $messageItem->id;
        if(!$messageId) {
            return;
        }

        $dataClass = $this->getDataClass();
        $dataClass->where(array(
            'message_id' => $fieldId
        ))->remove();
        if(isset($this[0])){
            foreach($this as $item){
                $item['message_id'] = $messageId;
                $dataClass->create($item);
            }
        }
    }
}
