<?php
/**
 * EvaEngine
 *
 * @link      https://github.com/AlloVince/eva-engine
 * @copyright Copyright (c) 2012 AlloVince (http://avnpc.com/)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    AlloVince
 */

namespace Epic\Form;

/**
 * Eva Form will automatic combination form Elements & Validators & Filters
 * Also allow add sub forms and unit validate
 * 
 * @category   Eva
 * @package    Eva_Form
 */
class EventForm extends \Event\Form\EventForm
{
    /**
     * Form basic elements
     *
     * @var array
     */
    protected $mergeElements = array (
        'id' => array (
            'name' => 'id',
            'type' => 'hidden',
            'options' => array (
                'label' => 'Id',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'title' => array (
            'name' => 'title',
            'type' => 'text',
            'options' => array (
                'label' => 'Title',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
       'urlName' => array (
            'name' => 'urlName',
            'type' => 'text',
            'options' => array (
                'label' => 'Url Name',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'eventStatus' => array (
            'name' => 'eventStatus',
            'type' => 'select',
            'options' => array (
                'label' => 'Event Status',
                'value_options' => array (
                    'active' => array (
                        'label' => 'Active',
                        'value' => 'active',
                    ),
                    'pending' => array (
                        'label' => 'Pending',
                        'value' => 'pending',
                    ),
                    'deleted' => array (
                        'label' => 'Deleted',
                        'value' => 'deleted',
                    ),
                ),
            ),
            'attributes' => array (
                'value' => 'active',
            ),
        ),
        'visibility' => array (
            'name' => 'visibility',
            'type' => 'select',
            'options' => array (
                'label' => 'Visibility',
                'value_options' => array (
                    'public' => array (
                        'label' => 'Public',
                        'value' => 'public',
                    ),
                    'private' => array (
                        'label' => 'Private',
                        'value' => 'private',
                    ),
                ),
            ),
            'attributes' => array (
                'value' => 'public',
            ),
        ),
       'startDay' => array (
            'name' => 'startDay',
            'type' => 'text',
            'options' => array (
                'label' => 'Start Day',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'startTime' => array (
            'name' => 'startTime',
            'type' => 'text',
            'options' => array (
                'label' => 'Start Time',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'endDay' => array (
            'name' => 'endDay',
            'type' => 'text',
            'options' => array (
                'label' => 'End Day',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'endTime' => array (
            'name' => 'endTime',
            'type' => 'text',
            'options' => array (
                'label' => 'End Time',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'timezone' => array (
            'name' => 'timezone',
            'type' => 'number',
            'options' => array (
                'label' => 'Timezone',
            ),
            'attributes' => array (
                'value' => '0',
            ),
        ),
        'longitude' => array (
            'name' => 'longitude',
            'type' => 'text',
            'options' => array (
                'label' => 'Longitude',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'latitude' => array (
            'name' => 'latitude',
            'type' => 'text',
            'options' => array (
                'label' => 'Latitude',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'location' => array (
            'name' => 'location',
            'type' => 'text',
            'options' => array (
                'label' => 'Location',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'city' => array (
            'name' => 'city',
            'type' => 'select',
            'options' => array (
                'label' => 'City',
                'value_options' => array (
                    array(
                        'label' => 'EUROPE',
                        'options' => array(
                            array(
                                'label' => 'Amsterdam',
                                'value' => 'Amsterdam',
                            ),
                            array(
                                'label' => 'Florence',
                                'value' => 'Florence',
                            ),
                            array(
                                'label' => 'Prague',
                                'value' => 'Prague',
                            ),
                            array(
                                'label' => 'Athens',
                                'value' => 'Athens',
                            ),
                            array(
                                'label' => 'Istanbul',
                                'value' => 'Istanbul',
                            ),
                            array(
                                'label' => 'Rome',
                                'value' => 'Rome',
                            ),
                            array(
                                'label' => 'Barcelona',
                                'value' => 'Barcelona',
                            ),
                            array(
                                'label' => 'Lisbon',
                                'value' => 'Lisbon',
                            ),
                            array(
                                'label' => 'Seville',
                                'value' => 'Seville',
                            ),
                            array(
                                'label' => 'Berlin',
                                'value' => 'Berlin',
                            ),
                            array(
                                'label' => 'London',
                                'value' => 'London',
                            ),
                            array(
                                'label' => 'Venice',
                                'value' => 'Venice',
                            ),
                            array(
                                'label' => 'Brussels',
                                'value' => 'Brussels',
                            ),
                            array(
                                'label' => 'Madrid',
                                'value' => 'Madrid',
                            ),
                            array(
                                'label' => 'Vienna',
                                'value' => 'Vienna',
                            ),
                            array(
                                'label' => 'Budapest',
                                'value' => 'Budapest',
                            ),
                            array(
                                'label' => 'Milan',
                                'value' => 'Milan',
                            ),
                            array(
                                'label' => 'Zurich',
                                'value' => 'Zurich',
                            ),
                            array(
                                'label' => 'Copenhagen',
                                'value' => 'Copenhagen',
                            ),
                            array(
                                'label' => 'Naples',
                                'value' => 'Naples',
                            ),
                            array(
                                'label' => 'Dublin',
                                'value' => 'Dublin',
                            ),
                            array(
                                'label' => 'Paris',
                                'value' => 'Paris',
                            ),
                        ),

                    ),

                    array(
                        'label' => 'Africa & Middle EAST',
                        'options' => array(
                            array(
                                'label' => 'Cairo',
                                'value' => 'Cairo',
                            ),
                            array(
                                'label' => 'Marrakech',
                                'value' => 'Marrakech',
                            ),
                            array(
                                'label' => 'Tel Aviv',
                                'value' => 'Tel Aviv',
                            ),
                        ),
                    ),

                    array(
                        'label' => 'Amercia',
                        'options' => array(
                            array(
                                'label' => 'Las Vegas',
                                'value' => 'Las Vegas',
                            ),
                            array(
                                'label' => 'Los Angeles',
                                'value' => 'Los Angeles',
                            ),
                            array(
                                'label' => 'Miami',
                                'value' => 'Miami',
                            ),
                            array(
                                'label' => 'New York',
                                'value' => 'New York',
                            ),
                            array(
                                'label' => 'San Francisco',
                                'value' => 'San Francisco',
                            ),
                            array(
                                'label' => 'Washington D.C.',
                                'value' => 'Washington D.C.',
                            ),
                            array(
                                'label' => 'Buenos Aires',
                                'value' => 'Buenos Aires',
                            ),
                            array(
                                'label' => 'Rio De Janeiro',
                                'value' => 'Rio De Janeiro',
                            ),
                            array(
                                'label' => 'San Paulo',
                                'value' => 'San Paulo',
                            ),
                        ),
                    ),

                    array(
                        'label' => 'Asia',
                        'options' => array(
                            array(
                                'label' => 'Shanghai',
                                'value' => 'Shanghai',
                            ),
                            array(
                                'label' => 'Beijing',
                                'value' => 'Beijing',
                            ),
                            array(
                                'label' => 'Guangzhou',
                                'value' => 'Guangzhou',
                            ),
                            array(
                                'label' => 'Nanjing',
                                'value' => 'Nanjing',
                            ),
                            array(
                                'label' => 'Hong Kong',
                                'value' => 'Hong Kong',
                            ),
                            array(
                                'label' => 'Singapore',
                                'value' => 'Singapore',
                            ),
                        ),
                    ),

                    array(
                        'label' => 'Other',
                        'options' => array(
                            array(
                                'label' => 'Other',
                                'value' => 'Other',
                            ),

                        ),
                    ),

                ),
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
    protected $mergeFilters = array (
        'id' => array (
            'name' => 'id',
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
        'title' => array (
            'name' => 'title',
            'required' => false,
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
                'stringLength' => array (
                    'name' => 'StringLength',
                    'options' => array (
                        'max' => '255',
                    ),
                ),
            ),
        ),
 
        'eventStatus' => array (
            'name' => 'eventStatus',
            'required' => false,
            'filters' => array (
            ),
            'validators' => array (
                'inArray' => array (
                    'name' => 'InArray',
                    'options' => array (
                        'haystack' => array (
                            'active',
                            'finished',
                            'disputed',
                            'trashed',
                        ),
                    ),
                ),
            ),
        ),
        'visibility' => array (
            'name' => 'visibility',
            'required' => false,
            'filters' => array (
            ),
            'validators' => array (
                'inArray' => array (
                    'name' => 'InArray',
                    'options' => array (
                        'haystack' => array (
                            'public',
                            'private',
                        ),
                    ),
                ),
            ),
        ),

        'startDay' => array (
            'name' => 'startDay',
            'required' => false,
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
                'stringLength' => array (
                    'name' => 'StringLength',
                    'options' => array (
                        'max' => NULL,
                    ),
                ),
            ),
        ),
        'startTime' => array (
            'name' => 'startTime',
            'required' => false,
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
        'endDay' => array (
            'name' => 'endDay',
            'required' => false,
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
                'stringLength' => array (
                    'name' => 'StringLength',
                    'options' => array (
                        'max' => NULL,
                    ),
                ),
            ),
        ),
        'endTime' => array (
            'name' => 'endTime',
            'required' => false,
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
        'urlName' => array (
            'name' => 'urlName',
            'required' => false,
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
                'stringLength' => array (
                    'name' => 'StringLength',
                    'options' => array (
                        'max' => '255',
                    ),
                ),
            ),
        ),
        'timezone' => array (
            'name' => 'timezone',
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
        'longitude' => array (
            'name' => 'longitude',
            'required' => false,
            'filters' => array (
                'stripTags' => array (
                    'name' => 'StripTags',
                ),
                'stringTrim' => array (
                    'name' => 'StringTrim',
                ),
            ),
            'validators' => array (
                'stringLength' => array (
                    'name' => 'StringLength',
                    'options' => array (
                        'max' => '50',
                    ),
                ),
            ),
        ),
        'latitude' => array (
            'name' => 'latitude',
            'required' => false,
            'filters' => array (
                'stripTags' => array (
                    'name' => 'StripTags',
                ),
                'stringTrim' => array (
                    'name' => 'StringTrim',
                ),
            ),
            'validators' => array (
                'stringLength' => array (
                    'name' => 'StringLength',
                    'options' => array (
                        'max' => '50',
                    ),
                ),
            ),
        ),
        'location' => array (
            'name' => 'location',
            'required' => false,
            'filters' => array (
                'stripTags' => array (
                    'name' => 'StripTags',
                ),
                'stringTrim' => array (
                    'name' => 'StringTrim',
                ),
            ),
            'validators' => array (
                'stringLength' => array (
                    'name' => 'StringLength',
                    'options' => array (
                        'max' => '255',
                    ),
                ),
            ),
        ),
    );

    public function getLanguages($element)
    {
        $translator = \Eva\Api::_()->getServiceManager()->get('translator');
        $locale = $translator->getLocale();
        $languages = \Eva\Locale\Data::getList($locale, 'language');
        $element['options']['value_options'] = $languages;
        $element['attributes']['value'] = $locale;
        return $element;
    }
}
