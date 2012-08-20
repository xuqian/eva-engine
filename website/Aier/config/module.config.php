<?php
return array(
    'router' => array(
        'routes' => array(
            'front' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Aier\Controller\AierController',
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
                        'controller' => 'Aier\Controller\PagesController',
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
                        'controller' => 'Aier\Controller\CategoryController',
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
                        'controller' => 'Aier\Controller\OrderController',
                        'action'     => 'index',
                    ),
                ),
                'priority' => 2,
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Aier\Controller\AierController' => 'Aier\Controller\AierController',
            'Aier\Controller\PagesController' => 'Aier\Controller\PagesController',
            'Aier\Controller\CategoryController' => 'Aier\Controller\CategoryController',
            'Aier\Controller\OrderController' => 'Aier\Controller\OrderController',
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../layout/aier.phtml',
            'aier/index' => __DIR__ . '/../view/aier/index.phtml',
            'aier/pages/get' => __DIR__ . '/../view/aier/pages/get.phtml',
            'aier/category/get' => __DIR__ . '/../view/aier/category/get.phtml',
            'aier/order/index' => __DIR__ . '/../view/aier/order/index.phtml',
        ),

    ),

    'page_components' => array(
        'slider' => array(
            'module' => 'Aier',
            'name' => 'slider',
            'title' => '首页轮播横幅',
            'path' => 'components/slider',
            'description' => '首页轮播横幅'
        ),
        'qq' => array(
            'module' => 'Aier',
            'name' => 'qq',
            'title' => 'QQ在线状态',
            'path' => 'components/qq',
            'description' => '代码获得地址：http://wp.qq.com/index.html'
        ),
        'weibo' => array(
            'module' => 'Aier',
            'name' => 'weibo',
            'title' => '微博展示栏',
            'path' => 'components/weibo',
            'description' => '微博秀，代码获得：http://weibo.com/tool/weiboshow'
        ),
        'phone' => array(
            'module' => 'Aier',
            'name' => 'phone',
            'title' => '首页热线电话',
            'path' => 'components/phone',
            'description' => '热线电话'
        ),
    ),

);
