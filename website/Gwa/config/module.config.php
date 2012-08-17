<?php
return array(
    'router' => array(
        'routes' => array(
            'front' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Gwa\Controller\GwaController',
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
                        'controller' => 'Gwa\Controller\PagesController',
                        'action' => 'get',
                    ),
                ),
                'priority' => 2,
            ),
            'frontcategory' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/category[/:id][/]',
                    'constraints' => array(
                        'id'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Gwa\Controller\CategoryController',
                        'action' => 'get',
                    ),
                ),
                'priority' => 2,
            ),
            'frontorder' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/order/',
                    'defaults' => array(
                        'controller' => 'Gwa\Controller\OrderController',
                        'action'     => 'index',
                    ),
                ),
                'priority' => 2,
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Gwa\Controller\GwaController' => 'Gwa\Controller\GwaController',
            'Gwa\Controller\PagesController' => 'Gwa\Controller\PagesController',
            'Gwa\Controller\CategoryController' => 'Gwa\Controller\CategoryController',
            'Gwa\Controller\OrderController' => 'Gwa\Controller\OrderController',
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../layout/gwa.phtml',
            'gwa/index' => __DIR__ . '/../view/gwa/index.phtml',
            'gwa/pages/get' => __DIR__ . '/../view/gwa/pages/get.phtml',
            'gwa/category/get' => __DIR__ . '/../view/gwa/category/get.phtml',
            'gwa/order/index' => __DIR__ . '/../view/gwa/order/index.phtml',
        ),

    ),

    'page_components' => array(
        'slider' => array(
            'module' => 'Gwa',
            'name' => 'slider',
            'title' => '首页轮播横幅',
            'path' => 'components/slider',
            'description' => '首页轮播横幅'
        ),
        'bbs' => array(
            'module' => 'Gwa',
            'name' => 'bbs',
            'title' => '论坛RSS地址',
            'path' => 'components/bbs',
            'description' => '论坛RSS地址，用于显示首页论坛热贴列表'
        ),
        'ad' => array(
            'module' => 'Gwa',
            'name' => 'ad',
            'title' => '首页广告位',
            'path' => 'components/ad',
            'description' => '首页广告位'
        ),
        'adside' => array(
            'module' => 'Gwa',
            'name' => 'ad',
            'title' => '侧栏广告位',
            'path' => 'components/adside',
            'description' => '侧栏广告位'
        ),
        'phone' => array(
            'module' => 'Gwa',
            'name' => 'phone',
            'title' => '热线电话',
            'path' => 'components/phone',
            'description' => '热线电话'
        ),
    ),

);
