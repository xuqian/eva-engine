<?php
namespace Blog\Form;

use Zend\Form\Form;

class PostForm extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->setName('post');
        $this->setAttribute('method', 'post');

        // Id
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        // Artist        
        $this->add(array(
            'name' => 'artist',
            'attributes' => array(
                'type'  => 'text',
                'label' => 'Artist',
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
                'label' => 'Title',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'label' => 'Go',
                'id' => 'submitbutton',
            ),
        ));

    }
}
