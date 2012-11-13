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

use Epic\Form\UserCreateForm;

/**
 * Eva Form will automatic combination form Elements & Validators & Filters
 * Also allow add sub forms and unit validate
 * 
 * @category   Eva
 * @package    Eva_Form
 */
class AccountEditForm extends UserCreateForm
{
    protected $validationGroup = array(
        'id',
        'firstName',
        'lastName',
        'gender',
        'language',
        'Profile' => array(
            'site',
            'birthday',
            'country',
            'address',
            'city',
            'province',
            'phoneMobile',
            'bio'
        ),
    );
}
