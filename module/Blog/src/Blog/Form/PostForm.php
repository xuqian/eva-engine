<?php
namespace Blog\Form;

class PostForm extends \Eva\Form\Form
{
    /**
     * Form basic elements
     *
     * @var array
     */
    protected $baseElements = array (
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
        'status' => array (
            'name' => 'status',
            'type' => 'select',
            'options' => array (
                'label' => 'Status',
                'value_options' => array (
                    array (
                        'label' => 'Deleted',
                        'value' => 'deleted',
                    ),
                    array (
                        'label' => 'Draft',
                        'value' => 'draft',
                    ),
                    array (
                        'label' => 'Published',
                        'value' => 'published',
                    ),
                    array (
                        'label' => 'Pending',
                        'value' => 'pending',
                    ),
                ),
            ),
            'attributes' => array (
                'value' => 'published',
            ),
        ),
        'visibility' => array (
            'name' => 'visibility',
            'type' => 'select',
            'options' => array (
                'label' => 'Visibility',
                'value_options' => array (
                    array (
                        'label' => 'Public',
                        'value' => 'public',
                    ),
                    array (
                        'label' => 'Private',
                        'value' => 'private',
                    ),
                    array (
                        'label' => 'Password',
                        'value' => 'password',
                    ),
                ),
            ),
            'attributes' => array (
            ),
        ),
        'codeType' => array (
            'name' => 'codeType',
            'type' => 'radio',
            'options' => array (
                'label' => 'Code Type',
                'value_options' => array (
                    array (
                        'label' => 'Markdown',
                        'value' => 'markdown',
                    ),
                    array (
                        'label' => 'reStructuredText',
                        'value' => 'reStructuredText',
                    ),
                    array (
                        'label' => 'HTML',
                        'value' => 'html',
                    ),
                    /*
                    array (
                        'label' => 'Wiki',
                        'value' => 'wiki',
                    ),
                    array (
                        'label' => 'Ubb',
                        'value' => 'ubb',
                    ),
                    array (
                        'label' => 'Other',
                        'value' => 'other',
                    ),
                    */
                ),
            ),
            'attributes' => array (
                'value' => 'markdown',
            ),
        ),
        'language' => array (
            'name' => 'language',
            'type' => 'select',
            'callback' => 'getLanguages',
            'options' => array (
                'label' => 'Language',
            ),
            'attributes' => array (
                'value' => 'en',
            ),
        ),

        'trackback' => array (
            'name' => 'trackback',
            'type' => 'text',
            'options' => array (
                'label' => 'Trackback',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'urlName' => array (
            'name' => 'urlName',
            'type' => 'text',
            'options' => array (
                'label' => 'Post Url',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'preview' => array (
            'name' => 'preview',
            'type' => 'text',
            'options' => array (
                'label' => 'Preview',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'postPassword' => array (
            'name' => 'postPassword',
            'type' => 'text',
            'options' => array (
                'label' => 'Post Password',
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
        'commentStatus' => array (
            'name' => 'commentStatus',
            'type' => 'select',
            'options' => array (
                'label' => 'Comment Status',
                'value_options' => array (
                    array (
                        'label' => 'Open',
                        'value' => 'open',
                    ),
                    array (
                        'label' => 'Closed',
                        'value' => 'closed',
                    ),
                    array (
                        'label' => 'Authority',
                        'value' => 'authority',
                    ),
                ),
            ),
            'attributes' => array (
                'value' => 'open',
            ),
        ),
        'commentType' => array (
            'name' => 'commentType',
            'type' => 'select',
            'options' => array (
                'label' => 'Comment Type',
                'value_options' => array (
                    array (
                        'label' => 'Local',
                        'value' => 'local',
                    ),
                    array (
                        'label' => 'Disqus',
                        'value' => 'disqus',
                    ),
                    array (
                        'label' => 'Youyan',
                        'value' => 'youyan',
                    ),
                    array (
                        'label' => 'Duoshuo',
                        'value' => 'duoshuo',
                    ),
                ),
            ),
            'attributes' => array (
                'value' => 'local',
            ),
        ),
    );

    /**
     * Form basic Validators
     *
     * @var array
     */
    protected $baseFilters = array (
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
        'status' => array (
            'name' => 'status',
            'required' => false,
            'filters' => array (
            ),
            'validators' => array (
                'inArray' => array (
                    'name' => 'InArray',
                    'options' => array (
                        'haystack' => array (
                            'deleted',
                            'draft',
                            'published',
                            'pending',
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
                'notEmpty' => array (
                    'name' => 'NotEmpty',
                    'options' => array (
                    ),
                ),
                'inArray' => array (
                    'name' => 'InArray',
                    'options' => array (
                        'haystack' => array (
                            'public',
                            'private',
                            'password',
                        ),
                    ),
                ),
            ),
        ),
        'codeType' => array (
            'name' => 'codeType',
            'required' => false,
            'filters' => array (
            ),
            'validators' => array (
                'inArray' => array (
                    'name' => 'InArray',
                    'options' => array (
                        'haystack' => array (
                            'markdown',
                            'html',
                            'wiki',
                            'reStructuredText',
                            'ubb',
                            'other',
                        ),
                    ),
                ),
            ),
        ),
        'language' => array (
            'name' => 'language',
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
                        'max' => '5',
                    ),
                ),
            ),
        ),

        'trackback' => array (
            'name' => 'trackback',
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
        'preview' => array (
            'name' => 'preview',
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
                        'max' => '500',
                    ),
                ),
            ),
        ),
        'postPassword' => array (
            'name' => 'postPassword',
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
                        'max' => '32',
                    ),
                ),
            ),
        ),
        'commentStatus' => array (
            'name' => 'commentStatus',
            'required' => false,
            'filters' => array (
            ),
            'validators' => array (
                'inArray' => array (
                    'name' => 'InArray',
                    'options' => array (
                        'haystack' => array (
                            'open',
                            'closed',
                            'authority',
                        ),
                    ),
                ),
            ),
        ),
        'commentType' => array (
            'name' => 'commentType',
            'required' => false,
            'filters' => array (
            ),
            'validators' => array (
                'inArray' => array (
                    'name' => 'InArray',
                    'options' => array (
                        'haystack' => array (
                            'local',
                            'disqus',
                            'youyan',
                            'duoshuo',
                        ),
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
