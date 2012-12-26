<?php
namespace Epic\Form;

use Eva\Form\Form;
use Zend\Form\Element;

class EventEditForm extends EventCreateForm
{
    protected $mergeElements = array(
    );

    protected $mergeFilters = array(
        'urlName' =>     array(
            'validators' => array(
                'db' => array(
                    'name' => 'Eva\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table' => 'event_events',
                        'field' => 'urlName',
                        'exclude' => array(
                            'field' => 'id',
                        ),
                    ),
                ),
            ),
        ),
    );
}
