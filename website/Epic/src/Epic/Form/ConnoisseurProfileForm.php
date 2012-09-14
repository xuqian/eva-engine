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
class ConnoisseurProfileForm extends \Eva\Form\RestfulForm
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
        'industry' => array (
            'name' => 'industry',
            'type' => 'text',
            'options' => array (
                'label' => 'Industry',
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
                'label' => 'Few	words about your yourself',
            ),
            'attributes' => array (
                'value' => '',
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
        'centralInterests' => array (
            'name' => 'centralInterests',
            'type' => 'multiCheckbox',
            'options' => array (
                'label' => 'Central Interests',
                'value_options' => array (
                    array (
                        'label' => 'Gastronomy and Fine Dining',
                        'value' => 'Gastronomy and Fine Dining',
                    ),
                    array (
                        'label' => 'Wine(oenology)',
                        'value' => 'Wine(oenology)',
                    ),
                    array (
                        'label' => 'Fine Spirit: Rhum, Cognac, Armagnac, Whisky, Vodka, Gin',
                        'value' => 'Fine Spirit: Rhum, Cognac, Armagnac, Whisky, Vodka, Gin',
                    ),
                    array (
                        'label' => 'Cocktails',
                        'value' => 'Cocktails',
                    ),
                    array (
                        'label' => 'Cigar',
                        'value' => 'Cigar',
                    ),
                    array (
                        'label' => 'Cooking',
                        'value' => 'Cooking',
                    ),
                    array (
                        'label' => 'Photographing food',
                        'value' => 'Photographing food',
                    ),
                    array (
                        'label' => 'Others',
                        'value' => 'Others',
                    ),
                ),
            ),
        ),
        'youMightInterestedIn' => array (
            'name' => 'youMightInterestedIn',
            'type' => 'multiCheckbox',
            'options' => array (
                'label' => 'You might interested in',
                'value_options' => array (
                    array (
                        'label' => 'Events(cocktail parties, wine tasting, tea party...)',
                        'value' => 'Events(cocktail parties, wine tasting, tea party...)',
                    ),
                    array (
                        'label' => 'Exhibitions',
                        'value' => 'Exhibitions',
                    ),
                    array (
                        'label' => 'Wine Trips',
                        'value' => 'Wine Trips',
                    ),
                    array (
                        'label' => 'Buying and collection Advices',
                        'value' => 'Buying and collection Advices',
                    ),
                    array (
                        'label' => 'Photo sharing',
                        'value' => 'Photo sharing',
                    ),
                    array (
                        'label' => 'Cooking classes',
                        'value' => 'Cooking classes',
                    ),
                    array (
                        'label' => 'Insider opinions sharing(locating new spots for dining, drinking.)',
                        'value' => 'Insider opinions sharing(locating new spots for dining, drinking.)',
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
