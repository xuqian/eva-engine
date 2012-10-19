<?php
return array(
    'router' => array(
        'routes' => array(
            'front' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'PreregController',
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
                        'controller' => 'PagesController',
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
                        'controller' => 'PreregController',
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
                        'controller' => 'LanguageController',
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
                        'id'     => 'example|paypal|alipay|paypalsearch|alipaysearch',
                    ),
                    'defaults' => array(
                        'controller' => 'PayController',
                        'action' => 'get',
                    ),
                ),
                'priority' => 2,
            ),
            'ad' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/ad/',
                    'defaults' => array(
                        'controller' => 'AdController',
                        'action'     => 'index',
                    ),
                ),
                'priority' => 2,
            ),
            'login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/login/',
                    'defaults' => array(
                        'controller' => 'LoginController',
                        'action'     => 'index',
                    ),
                ),
                'priority' => 2,
            ),
            'city' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/city/',
                    'defaults' => array(
                        'controller' => 'CityController',
                        'action'     => 'index',
                    ),
                ),
                'priority' => 2,
            ),
            'user' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/user/[:id]',
                    'constraints' => array(
                        'id'     => '[a-zA-Z-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'UserController',
                        'action' => 'index',
                    ),
                ),
                'priority' => 2,
            ),
            'feed' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/feed[/]',
                    'constraints' => array(
                        'id'     => '[a-zA-Z-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'FeedController',
                        'action' => 'index',
                    ),
                ),
                'priority' => 2,
            ),


        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'PreregController' => 'Epic\Controller\PreregController',
            'PagesController' => 'Epic\Controller\PagesController',
            'PayController' => 'Epic\Controller\PayController',
            'LanguageController' => 'Epic\Controller\LanguageController',
            'AdController' => 'Epic\Controller\AdController',
            'LoginController' => 'Epic\Controller\LoginController',
            'CityController' => 'Epic\Controller\CityController',
            'UserController' => 'Epic\Controller\UserController',
            'FeedController' => 'Epic\Controller\FeedController',
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'epic' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../layout/layout.phtml',
            'layout/coming' => __DIR__ . '/../layout/coming.phtml',
            'layout/empty' => __DIR__ . '/../layout/empty.phtml',
            'layout/login' => __DIR__ . '/../layout/login.phtml',
        ),
    ),

    'page_components' => array(
        'top' => array(
            'module' => 'Epic',
            'name' => 'top',
            'title' => 'Top Advertisement',
            'path' => 'components/top',
            'description' => 'Top Advertisement Code Management'
        ),
        'middle' => array(
            'module' => 'Epic',
            'name' => 'middle',
            'title' => 'Side Ad',
            'path' => 'components/middle',
            'description' => 'Side Advertisement Code Management'
        ),
        'end' => array(
            'module' => 'Epic',
            'name' => 'end',
            'title' => 'Bottom Advertisement',
            'path' => 'components/end',
            'description' => 'Bottom Advertisement Code Management'
        ),
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
