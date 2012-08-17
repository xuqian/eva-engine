<?php
namespace Gwa\Form;

use Eva\Form\Form;
use Zend\Form\Element;

class ContactForm extends Form
{
    protected $fieldsMap = array(
        
    );

    protected $baseElements = array(
        'name' => array (
            'name' => 'name',
            'attributes' => array (
                'type' => 'text',
                'label' => '姓名',
                'value' => '',
            ),
        ),
        'phone' => array (
            'name' => 'phone',
            'attributes' => array (
                'type' => 'text',
                'label' => '电话',
                'value' => '',
            ),
        ),
        'im' => array (
            'name' => 'im',
            'attributes' => array (
                'type' => 'text',
                'label' => 'QQ',
                'value' => '',
            ),
        ),

        'message' => array (
            'name' => 'message',
            'attributes' => array (
                'type'  => 'textarea',
                'label' => '留言',
                'value' => '',
            ),
        ),
    );

    /**
     * Form basic Validators
     *
     * @var array
     */
    protected $baseFilters = array (
        'name' => array (
            'name' => 'name',
            'required' => true,
            'filters' => array (
                'stripTags' => array (
                    'name' => 'StripTags',
                ),
                'stringTrim' => array (
                    'name' => 'StringTrim',
                ),
            ),
            'validators' => array (
                'notEmpty' => array (
                    'name' => 'NotEmpty',
                    'options' => array (
                    ),
                ),
            ),
        ),
        'phone' => array (
            'name' => 'phone',
            'required' => true,
            'filters' => array (
                'stripTags' => array (
                    'name' => 'StripTags',
                ),
                'stringTrim' => array (
                    'name' => 'StringTrim',
                ),
            ),
            'validators' => array (
            ),
        ),
    );
}
