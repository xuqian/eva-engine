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

namespace Eva\Form\View\Helper;

use Zend\Form\FormInterface;
use Zend\Form\ElementInterface;

/**
 * Core Form Input helper
 * This helper will call other Zend official helpers to create Form Element
 * 
 * @category   Eva
 * @package    Eva_Form
 * @subpackage View
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Input extends \Zend\Form\View\Helper\AbstractHelper
{

    protected function autoValidator($element, $filter)
    {
        $class = $element->getAttribute('class');

        $validateClass = array();
        if(isset($filter['required']) && $filter['required']){
            $validateClass[] = 'validate[required]';
        }
        if($validateClass){
            $class .= $class ? ' ' . implode(' ', $validateClass) : implode(' ', $validateClass);
            $element->setAttribute('class', $class);
        }

        return $element;
    }

    protected function isInputElement($elementType)
    {
        $notElementTypes = array(
            'label',
            'formElementErrors',
        );

        return in_array($elementType, $notElementTypes) ? false : true;
    }

    /**
    * Invoke helper as functor
    *
    * Proxies to {@link render()}.
    * 
    * @param  ElementInterface $element 
    * @return string
    */
    public function __invoke(ElementInterface $element, array $options = array(), array $filter = array())
    {
        $defaultOptions = array(
            'type' => 'formInput',
            'args' => array(),
            'i18n' => true,
            'validator' => true,
            'reorder' => false,
        );

        $options = array_merge($defaultOptions, $options);
        $elementType = $options['type'];


        $i18n = $options['i18n'];

        $args = array();
        if(isset($options['args'])){
            if($options['args'] && is_array($options['args'])){
                foreach($options['args'] as $key => $value){
                    $args[] = $value; 
                }
            }
        }

        if(true === $options['validator'] && $filter && $this->isInputElement($elementType)){
            $element = $this->autoValidator($element, $filter);
        }

        //NOTE: clone element not effect to form original element
        $element = clone $element;

        if($options){
            foreach($options as $key => $value){
                //$element->setAttribute($key, $value);
            }
            if(true === $i18n){
                //$element = $this->translateElement($element);
            }
        }

        //form helper first argment is alway element self
        array_unshift($args, $element);

        $view = $this->getView();
        return call_user_func_array(array(
            &$view,
            $elementType,
        ), $args);
    }
}
