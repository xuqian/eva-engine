<?php
/**
 * EvaEngine
 *
 * @link      https://github.com/AlloVince/eva-engine
 * @copyright Copyright (c) 2012 AlloVince (http://avnpc.com/)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Eva_Api.php
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
class ProfessionalProfileForm extends \Eva\Form\RestfulForm
{
    /**
     * Form basic elements
     *
     * @var array
     */
    protected $baseElements = array (
        'user_id' => array (
            'name' => 'user_id',
            'type' => 'hidden',
            'options' => array (
                'label' => 'User_id',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'firstName' => array (
            'name' => 'firstName',
            'type' => 'text',
            'options' => array (
                'label' => 'First Name',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'lastName' => array (
            'name' => 'lastName',
            'type' => 'text',
            'options' => array (
                'label' => 'Last Name',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'birthday' => array (
            'name' => 'birthday',
            'type' => 'text',
            'options' => array (
                'label' => 'Birthday',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'country' => array (
            'name' => 'country',
            'type' => 'select',
            'callback' => 'getCountries',
            'options' => array (
                'label' => 'Country',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'hobbies' => array (
            'name' => 'hobbies',
            'type' => 'text',
            'options' => array (
                'label' => 'Hobbies',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'bio' => array (
            'name' => 'bio',
            'type' => 'textarea',
            'options' => array (
                'label' => 'Few	words about yourself',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'school' => array (
            'name' => 'school',
            'type' => 'text',
            'options' => array (
                'label' => 'School',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'degree' => array (
            'name' => 'degree',
            'type' => 'text',
            'options' => array (
                'label' => 'Degree',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'industry' => array (
            'name' => 'industryIndustrie',
            'type' => 'select',
            'options' => array (
                'label' => 'Industry',
                'value_options' => array (
                    array (
                        'label' => 'Food, Wine and Spirit Production',
                        'value' => 'Food, Wine and Spirit Production',
                    ),
                    array (
                        'label' => 'Hospitality',
                        'value' => 'Hospitality',
                    ),
                    array (
                        'label' => 'Restaurant, bar and club',
                        'value' => 'Restaurant, bar and club',
                    ),
                    array (
                        'label' => 'Distribution and Trade',
                        'value' => 'Distribution and Trade',
                    ),
                    array (
                        'label' => 'Media and Press',
                        'value' => 'Media and Press',
                    ),
                    array (
                        'label' => 'Marketing and Communication',
                        'value' => 'Marketing and Communication',
                    ),
                    array (
                        'label' => 'Consultancy',
                        'value' => 'Consultancy',
                    ),
                    array (
                        'label' => 'Educational Institution',
                        'value' => 'Educational Institution',
                    ),
                    array (
                        'label' => 'Research and Development',
                        'value' => 'Research and Development',
                    ),
                    array (
                        'label' => 'Other',
                        'value' => 'Other',
                    ),
                ),
            ),
        ),
        'phoneBusiness' => array (
            'name' => 'phoneBusiness',
            'type' => 'text',
            'options' => array (
                'label' => 'Phone',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'address' => array (
            'name' => 'address',
            'type' => 'text',
            'options' => array (
                'label' => 'Address',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'howCouldWehelpYou' => array (
            'name' => 'howCouldWehelpYou',
            'type' => 'multiCheckbox',
            'options' => array (
                'label' => 'How could we help you?',
                'value_options' => array (
                    array (
                        'label' => 'Jobs and Intern Opportunities',
                        'value' => 'Jobs and Intern Opportunities',
                    ),
                    array (
                        'label' => 'Social Network Opportunities',
                        'value' => 'Social Network Opportunities',
                    ),
                    array (
                        'label' => 'Others',
                        'value' => 'Others',
                    ),
                ),
            ),
        ),
        'yourExpertise' => array (
            'name' => 'yourExpertise',
            'type' => 'multiCheckbox',
            'options' => array (
                'label' => 'Your Expertise',
                'value_options' => array (
                    array (
                        'label' => 'Chef, Sommelier, Mixologist barman',
                        'value' => 'Chef, Sommelier, Mixologist barman',
                    ),
                    array (
                        'label' => 'hospitality',
                        'value' => 'hospitality',
                    ),
                    array (
                        'label' => 'Restaurant and bar management',
                        'value' => 'Restaurant and bar management',
                    ),
                    array (
                        'label' => 'Distribution, Logistics, and trade',
                        'value' => 'Distribution, Logistics, and trade',
                    ),
                    array (
                        'label' => 'Public Communication',
                        'value' => 'Public Communication',
                    ),
                    array (
                        'label' => 'Marketing and Promotion',
                        'value' => 'Marketing and Promotion',
                    ),
                    array (
                        'label' => 'Events Planning',
                        'value' => 'Events Planning',
                    ),
                    array (
                        'label' => 'Consultancy',
                        'value' => 'Consultancy',
                    ),
                    array (
                        'label' => 'Financial Service(seed funding, venture capital. Insurance)',
                        'value' => 'Financial Service(seed funding, venture capital. Insurance)',
                    ),
                    array (
                        'label' => 'Design',
                        'value' => 'Design',
                    ),
                    array (
                        'label' => 'Photographing',
                        'value' => 'Photographing',
                    ),
                    array (
                        'label' => 'Creative Writing',
                        'value' => 'Creative Writing',
                    ),
                    array (
                        'label' => 'Journalism',
                        'value' => 'Journalism',
                    ),
                    array (
                        'label' => 'Legal Issues',
                        'value' => 'Legal Issues',
                    ),
                    array (
                        'label' => 'Academic and Research',
                        'value' => 'Academic and Research',
                    ),
                    array (
                        'label' => 'Others',
                        'value' => 'Others',
                    ),
                ),
            ),
        ),
    );

    public function getCountries($element)
    {
        $translator = \Eva\Api::_()->getServiceManager()->get('translator');
        $locale = $translator->getLocale();
        $countries = \Eva\Locale\Data::getList($locale, 'territory');
        $element['options']['value_options'] = $countries;
        return $element;
    }
}
