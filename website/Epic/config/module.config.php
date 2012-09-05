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
            'frontcategory' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/category[/:id][/]',
                    'constraints' => array(
                        'id'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Epic\Controller\CategoryController',
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
                        'controller' => 'Epic\Controller\OrderController',
                        'action'     => 'index',
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
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../layout/epic.phtml',
            'epic/index' => __DIR__ . '/../view/epic/index.phtml',
            'epic/pages/get' => __DIR__ . '/../view/epic/pages/get.phtml',
        ),

    ),

    'page_components' => array(

    ),

);
