<?php
/**
 * EvaEngine
 *
 * @link      https://github.com/AlloVince/eva-engine
 * @copyright Copyright (c) 2012 AlloVince (http://avnpc.com/)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    AlloVince
 */

namespace Event\Form;

/**
 * Eva Form will automatic combination form Elements & Validators & Filters
 * Also allow add sub forms and unit validate
 * 
 * @category   Eva
 * @package    Eva_Form
 */
class CategoryEventForm extends \Eva\Form\Form
{
    protected $category;

    protected $categories;
    
    /**
     * Form basic elements
     *
     * @var array
     */
    protected $baseElements = array (
        'category_id' => array (
            'name' => 'category_id',
            'type' => 'multiCheckbox',
            'options' => array (
                'label' => 'Event Categories',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'event_id' => array (
            'name' => 'event_id',
            'type' => 'hidden',
            'options' => array (
                'label' => 'Event_id',
            ),
            'attributes' => array (
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
        'category_id' => array (
            'name' => 'category_id',
            'required' => false,
            'filters' => array (
            ),
            'validators' => array (
                'notEmpty' => array (
                    'name' => 'NotEmpty',
                    'options' => array (
                    ),
                ),
            ),
        ),
        'event_id' => array (
            'name' => 'event_id',
            'required' => false,
            'filters' => array (
            ),
            'validators' => array (
                'notEmpty' => array (
                    'name' => 'NotEmpty',
                    'options' => array (
                    ),
                ),
            ),
        ),
    );

    public function getCategory()
    {
        if($this->category) {
            return $this->category;
        }

        $categoryId = $this->get('category_id')->getValue();
        if(!$categoryId){
            return array();
        }

        $model = \Eva\Api::_()->getModel('Event\Model\Category');
        $item = $model->getCategory($categoryId);
        return $item;
    }

    public function initCategories()
    {
        $cateModel = \Eva\Api::_()->getModel('Event\Model\Category');
        $categories = $cateModel->setItemList(array(
            'noLimit' => true
        ))->getCategoryList();
        $categories = $categories ? $categories->toArray() : array();
        $idArray = array();
        foreach($categories as $key => $cate) {
            $categories[$key]['category_id'] = $cate['id'];
            $idArray[$cate['id']] = $cate['id'];
        }
        $this->categories = $categories;

        $this->get('category_id')->setValueOptions($idArray);
        return array(
            'object' => $categories
        );
    }
}

