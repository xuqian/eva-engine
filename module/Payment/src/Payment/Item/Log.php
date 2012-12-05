<?php

namespace Payment\Item;

use Eva\Mvc\Item\AbstractItem;

class Log extends AbstractItem
{
    protected $dataSourceClass = 'Payment\DbTable\Logs';

    protected $relationships = array(
    );

    protected $map = array(
        'create' => array(
            'getRequestTime()',
        ),
        'save' => array(
            'getResponseTime()',
        ),
    );

    public function getRequestTime()
    {
        if(!$this->requestTime) {
            return $this->requestTime = \Eva\Date\Date::getNow();
        }
    }

    public function getResponseTime()
    {
        $this->responseTime = \Eva\Date\Date::getNow();
    }

    public function unserializeRequestData()
    {
        if ($this->requestData) {
            return $this->requestData = unserialize($this->requestData);
        }
    }

    public function unserializeResponseData()
    {
        if ($this->responseData) {
            return $this->responseData = unserialize($this->responseData);
        }
    }
}
