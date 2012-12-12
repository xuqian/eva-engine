<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            'Yicheng' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../layout/layout.phtml',
            'layout/welcome' => __DIR__ . '/../layout/welcome.phtml',
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

            'feed' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/feed[/]',
                    'defaults' => array(
                        'controller' => 'FeedController',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'tweet' => array(
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

            'register' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/register[/]',
                    'defaults' => array(
                        'controller' => 'UserController',
                        'action' => 'register',
                    ),
                ),
                'priority' => 2,
            ),

            'login' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/login/[:action/]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'controller' => 'LoginController',
                        'action' => 'index',
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
            'LoginController' => 'Yicheng\Controller\LoginController',
            'UserController' => 'Yicheng\Controller\UserController',
            'FeedController' => 'Yicheng\Controller\FeedController',
        ),
    ),

    'oauth' => array(
        'login_url_path' => '/feed/'
    ),
);
