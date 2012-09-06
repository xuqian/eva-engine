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
            'layout/layout' => __DIR__ . '/../layout/empty.phtml',
            'layout/coming' => __DIR__ . '/../layout/coming.phtml',
            'layout/empty' => __DIR__ . '/../layout/empty.phtml',
            'epic/index' => __DIR__ . '/../view/epic/index.phtml',
            'epic/pages/get' => __DIR__ . '/../view/epic/pages/get.phtml',
            'epic/reg/connoisseur' => __DIR__ . '/../view/epic/reg/connoisseur.phtml',
            'epic/reg/professional' => __DIR__ . '/../view/epic/reg/professional.phtml',
            'epic/reg/corporate' => __DIR__ . '/../view/epic/reg/corporate.phtml',
        ),

    ),

    'page_components' => array(

    ),

);
