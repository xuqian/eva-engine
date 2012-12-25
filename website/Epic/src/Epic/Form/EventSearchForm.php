<?php
namespace Epic\Form;

class EventSearchForm extends EventForm
{
    protected $mergeElements = array(
        'keyword' =>     array(
            'name' => 'keyword',
            'type' => 'text',
            'options' => array(
                'label' => 'Keyword',
            ),
            'attributes' => array(
            ),
        ),
        'group' =>     array(
            'name' => 'group',
            'type' => 'text',
            'options' => array(
                'label' => 'Group',
            ),
            'attributes' => array(
            ),
        ),
        'beforeStartDay' =>     array(
            'name' => 'beforeStartDay',
            'type' => 'text',
            'options' => array(
                'label' => 'Before Start Day',
            ),
            'attributes' => array(
            ),
        ),
        'afterStartDay' =>     array(
            'name' => 'afterStartDay',
            'type' => 'text',
            'options' => array(
                'label' => 'After Start Day',
            ),
            'attributes' => array(
            ),
        ),
        'beforeEndDay' =>     array(
            'name' => 'beforeEndDay',
            'type' => 'text',
            'options' => array(
                'label' => 'Before End Day',
            ),
            'attributes' => array(
            ),
        ),
        'afterEndDay' =>     array(
            'name' => 'afterEndDay',
            'type' => 'text',
            'options' => array(
                'label' => 'After End Day',
            ),
            'attributes' => array(
            ),
        ),
        'page' =>     array(
            'name' => 'page',
            'type' => 'text',
            'options' => array(
                'label' => 'Page',
            ),
            'attributes' => array(
                'value' => 1,
            ),
        ),
        'rows' =>     array(
            'name' => 'rows',
            'type' => 'text',
            'options' => array(
                'label' => 'Rows',
            ),
            'attributes' => array(
                'value' => 10,
            ),
        ),
        'order' =>     array(
            'name' => 'order',
            'type' => 'text',
            'options' => array(
                'label' => 'order',
            ),
            'attributes' => array(
            ),
        ),
    );

    public function prepareData($data)
    {
        if(!$data['page']){
            $data['page'] = 1;
        }

        if(!$data['order']) {
            $data['order'] = 'iddesc';
        }

        return $data;
    }
}
