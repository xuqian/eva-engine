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
class ProfileForm extends \User\Form\ProfileForm
{
    /**
     * Form basic elements
     *
     * @var array
     */
     protected $mergeElements = array (
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
 }
