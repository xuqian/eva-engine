<?php
return array(
    'router' => array(
        'routes' => array(
            'front' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Epic\Controller\PreregController',
                        'action'     => 'index',
                    ),
                ),
                'priority' => 2,
            ),
            'frontposts' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/pages[/:id]',
                    'constraints' => array(
                        'id'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Epic\Controller\PagesController',
                        'action' => 'get',
                    ),
                ),
                'priority' => 2,
            ),
            'prereg' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/reg/[:id]',
                    'constraints' => array(
                        'id'     => '[a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Epic\Controller\PreregController',
                        'action' => 'get',
                    ),
                ),
                'priority' => 2,
            ),
            'language' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/language/[:id]',
                    'constraints' => array(
                        'id'     => '[a-zA-Z-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Epic\Controller\LanguageController',
                        'action' => 'switch',
                    ),
                ),
                'priority' => 2,
            ),
            'pay' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/pay/[:id]',
                    'constraints' => array(
                        'id'     => 'example|paypal|alipay',
                    ),
                    'defaults' => array(
                        'controller' => 'Epic\Controller\PayController',
                        'action' => 'get',
                    ),
                ),
                'priority' => 2,
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Epic\Controller\PreregController' => 'Epic\Controller\PreregController',
            'Epic\Controller\PagesController' => 'Epic\Controller\PagesController',
            'Epic\Controller\PayController' => 'Epic\Controller\PayController',
            'Epic\Controller\LanguageController' => 'Epic\Controller\LanguageController',
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../layout/empty.phtml',
            'layout/coming' => __DIR__ . '/../layout/coming.phtml',
            'layout/empty' => __DIR__ . '/../layout/empty.phtml',
            'blank' => __DIR__ . '/../view/epic.phtml',
            'epic/index' => __DIR__ . '/../view/epic/index.phtml',
            'epic/pages/get' => __DIR__ . '/../view/epic/pages/get.phtml',
            'epic/reg/connoisseur' => __DIR__ . '/../view/epic/reg/connoisseur.phtml',
            'epic/reg/professional' => __DIR__ . '/../view/epic/reg/professional.phtml',
            'epic/reg/corporate' => __DIR__ . '/../view/epic/reg/corporate.phtml',
            'epic/pay/index' => __DIR__ . '/../view/epic/pay/index.phtml',
        ),

    ),

    'page_components' => array(

    ),
    
    'translator' => array(
        'locale' => 'en',
        'force_locale' => '',  //force_locale will cover locale
        'languages' => array(
            'en', 'zh', 'fr', 'zh_TW'
        ),
        'sub_languages' => array(
            'zh_TW'
        ),
        'translation_file_patterns' => array(
            'epic' => array(
                'type' => 'csv',
                'base_dir' => EVA_ROOT_PATH . '/website/Epic/data/languages/',
                'pattern' => '%s/epic.csv'
            ),
        ),
    ),
);
