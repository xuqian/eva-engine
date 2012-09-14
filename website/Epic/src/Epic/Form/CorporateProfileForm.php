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
class CorporateProfileForm extends \Eva\Form\RestfulForm
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
        'companyName' => array (
            'name' => 'companyName',
            'type' => 'text',
            'options' => array (
                'label' => 'Company Name',
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
        'industryIndustrie' => array (
            'name' => 'industryIndustrie',
            'type' => 'select',
            'options' => array (
                'label' => 'Industry/Industrie',
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
                'label' => 'Phone no',
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
        'bio' => array (
            'name' => 'bio',
            'type' => 'textarea',
            'options' => array (
                'label' => 'Few	words about your brand',
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
                        'label' => 'Exhibition',
                        'value' => 'exhibition',
                    ),
                    array (
                        'label' => 'Business network events',
                        'value' => 'business network events',
                    ),
                    array (
                        'label' => 'Branding',
                        'value' => 'branding',
                    ),
                    array (
                        'label' => 'Business partners, Merge and Acquisition',
                        'value' => 'Business partners, Merge and Acquisition',
                    ),
                    array (
                        'label' => 'Talents search and recruiting',
                        'value' => 'Talents search and recruiting',
                    ),
                    array (
                        'label' => 'Consulting Services',
                        'value' => 'Consulting Services',
                    ),
                    array (
                        'label' => 'Financial Services',
                        'value' => 'Financial Services',
                    ),
                    array (
                        'label' => 'Other',
                        'value' => 'Other',
                    ),
                ),
            ),
        ),
        'whatYouAreOffering' => array (
            'name' => 'whatYouAreOffering',
            'type' => 'multiCheckbox',
            'options' => array (
                'label' => 'What you are offering?',
                'value_options' => array (
                    array (
                        'label' => 'Jobs, internship Opportunities',
                        'value' => 'Jobs, internship Opportunities',
                    ),
                    array (
                        'label' => 'Exhibitions, Events',
                        'value' => 'Exhibitions, Events',
                    ),
                    array (
                        'label' => 'Distribution and International Trade',
                        'value' => 'Distribution and International Trade',
                    ),
                    array (
                        'label' => 'Consulting Service',
                        'value' => 'Consulting Service',
                    ),
                    array (
                        'label' => 'Talents search and recruiting',
                        'value' => 'Talents search and recruiting',
                    ),
                    array (
                        'label' => 'Consulting Services',
                        'value' => 'Consulting Services',
                    ),
                    array (
                        'label' => 'Financial Services',
                        'value' => 'Financial Services',
                    ),
                    array (
                        'label' => 'Other',
                        'value' => 'Other',
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
