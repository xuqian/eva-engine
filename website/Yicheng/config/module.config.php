<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            'Yicheng' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../layout/layout.phtml',
            'layout/welcome' => __DIR__ . '/../layout/welcome.phtml',
            'layout/newindex' => __DIR__ . '/../layout/newindex.phtml',
            'layout/index' => __DIR__ . '/../layout/index.phtml',
        ),
    ),
    'router' => array(
        'routes' => array(
            'index' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'IndexController',
                        'action'     => 'index',
                    ),
                ),
                'priority' => 2,
            ),

            'news' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/news[/]',
                    'defaults' => array(
                        'controller' => 'PagesController',
                        'action'     => 'news',
                    ),
                ),
                'priority' => 2,
            ),

            'home' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/home[/]',
                    'defaults' => array(
                        'controller' => 'IndexController',
                        'action'     => 'home',
                    ),
                ),
                'priority' => 2,
            ),

            'static' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/index[/][:id][/]',
                    'defaults' => array(
                        'controller' => 'IndexController',
                        'action'     => 'get',
                    ),
                ),
                'priority' => 2,
            ),

            'album' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/album[/][:id][/]',
                    'defaults' => array(
                        'controller' => 'AlbumController',
                        'action'     => 'get',
                    ),
                ),
                'priority' => 2,
            ),

            'blog' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/pages[/]',
                    'defaults' => array(
                        'controller' => 'PagesController',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'post' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/][:id][/]',
                            'constraints' => array(
                                'id' => '[a-zA-Z0-9_-]+'
                            ),
                            'defaults' => array(
                                'action' => 'get'
                            )
                        )
                    ),
                ),
                'priority' => 2,
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'PagesController' => 'Yicheng\Controller\PagesController',
            'IndexController' => 'Yicheng\Controller\IndexController',
            'AlbumController' => 'Yicheng\Controller\AlbumController',
        ),
    ),
);
