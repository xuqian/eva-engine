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

            'home' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/home[/]',
                    'defaults' => array(
                        'controller' => 'HomeController',
                        'action' => 'index'
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
                    'route' => '/login[/][:action][/]',
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

            'logout' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/logout[/]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'controller' => 'LoginController',
                        'action' => 'logout',
                    ),
                ),
                'priority' => 2,
            ),

            'reset' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/reset[/][:action][/]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ResetController',
                        'action' => 'index',
                    ),
                ),
                'priority' => 2,
            ),

            'share' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/share[/]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ShareController',
                        'action' => 'index',
                    ),
                ),
                'priority' => 2,
            ),

            'language' => array(
                'type' => 'Segment',
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

            'account' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/account/[:action][/]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AccountController',
                    ),
                ),
                'priority' => 2,
            ),

            'feed' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/feed/[:id]',
                    'constraints' => array(
                        'id'     => '[a-zA-Z0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'FeedController',
                        'action' => 'get',
                    ),
                ),
                'priority' => 2,
            ),

            'blog' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/blog[/:action][/:id][/]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z]+',
                        'id'     => '[0-9a-zA-Z]+',
                    ),
                    'defaults' => array(
                        'controller' => 'BlogController',
                        'action' => 'index',
                    ),
                ),
                'priority' => 2,
            ),
            
            'events' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/events[/]',
                    'constraints' => array(
                    ),
                    'defaults' => array(
                        'controller' => 'EventController',
                        'action' => 'index',
                    ),
                ),
                'priority' => 2,
                'child_routes' => array(
                    'operate' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[:action][/:id][/]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z]+',
                                'id'     => '[0-9a-zA-Z]+',
                            ),
                            'defaults' => array(
                                'controller' => 'EventController',
                                'action' => 'index'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                ),
            ),
            
            'event' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/event[/:id]',
                    'constraints' => array(
                        'id'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'EventController',
                        'action' => 'get',
                    ),
                ),
                'priority' => 2,
            ),

            'groups' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/groups[/]',
                    'constraints' => array(
                    ),
                    'defaults' => array(
                        'controller' => 'GroupController',
                        'action' => 'index',
                    ),
                ),
                'priority' => 2,
                'child_routes' => array(
                    'operate' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[:action][/:id][/]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z]+',
                                'id'     => '[0-9a-zA-Z]+',
                            ),
                            'defaults' => array(
                                'controller' => 'GroupController',
                                'action' => 'index'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                ),
            ),
            
            'group' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/group/[:id][/]',
                    'constraints' => array(
                        'id'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'GroupController',
                        'action' => 'get',
                    ),
                ),
                'priority' => 2,
                'may_terminate' => true,
                'child_routes' => array(
                    'blog' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'blog[/]',
                            'constraints' => array(
                            ),
                            'defaults' => array(
                                'action' => 'blog'
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'create' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'create[/]',
                                    'constraints' => array(
                                    ),
                                    'defaults' => array(
                                        'action' => 'postCreate'
                                    )
                                ),
                                'may_terminate' => true,
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'edit/[:post_id][/]',
                                    'constraints' => array(
                                        'post_id' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'postEdit'
                                    )
                                ),
                                'may_terminate' => true,
                            ),
                            'get' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'info/[:post_id][/]',
                                    'constraints' => array(
                                        'post_id' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'postGet'
                                    )
                                ),
                                'may_terminate' => true,
                            ),
                        ),
                    ),
                    'event' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'event[/]',
                            'constraints' => array(
                            ),
                            'defaults' => array(
                                'action' => 'event'
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'create' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'create[/]',
                                    'constraints' => array(
                                    ),
                                    'defaults' => array(
                                        'action' => 'eventCreate'
                                    )
                                ),
                                'may_terminate' => true,
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'edit/[:event_id][/]',
                                    'constraints' => array(
                                        'post_id' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'eventEdit'
                                    )
                                ),
                                'may_terminate' => true,
                            ),
                            'get' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'info/[:event_id][/]',
                                    'constraints' => array(
                                        'post_id' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'eventGet'
                                    )
                                ),
                                'may_terminate' => true,
                            ),
                        ),
                    ),
                ),
            ),

            'data' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/data[/]',
                    'constraints' => array(
                    ),
                    'defaults' => array(
                    ),
                ),
                'priority' => 2,
                'child_routes' => array(
                    'blog' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'blog[/]',
                            'constraints' => array(
                            ),
                            'defaults' => array(
                                'controller' => 'Blog\Controller\BlogController',
                                'action' => 'index'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'friend' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'friend[/]',
                            'constraints' => array(
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\FriendController',
                                'action' => 'index'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'isfriend' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'isfriend[/]',
                            'constraints' => array(
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\FriendController',
                                'action' => 'isfriend'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'event' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'event[/]',
                            'constraints' => array(
                            ),
                            'defaults' => array(
                                'controller' => 'Event\Controller\EventController',
                                'action' => 'index'
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'group' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'group[/]',
                            'constraints' => array(
                            ),
                            'defaults' => array(
                                'controller' => 'Group\Controller\GroupController',
                                'action' => 'index'
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'post' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'post[/]',
                                    'constraints' => array(
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Group\Controller\PostController',
                                        'action' => 'index'
                                    )
                                ),
                                'may_terminate' => true,
                            ),
                            'event' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'event[/]',
                                    'constraints' => array(
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Group\Controller\EventController',
                                        'action' => 'index'
                                    )
                                ),
                                'may_terminate' => true,
                            ),
                        ),
                    ),
                ), //my child_routes end
            ), //my end

            'my' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/my/[:action][/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'MyController',
                    ),
                    'may_terminate' => true,
                ),
                'priority' => 2,
            ), //my end

            'user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user[/]',
                    'constraints' => array(
                    ),
                    'defaults' => array(
                        'controller' => 'UserController',
                        'action' => 'index',
                    ),
                ),
                'priority' => 2,
                'may_terminate' => true,
                'child_routes' => array(
                    'profile' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[:id][/]',
                            'constraints' => array(
                                'id' => '[a-zA-Z0-9_-]+'
                            ),
                            'defaults' => array(
                                'action' => 'get'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'blog' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'blog[/]',
                                    'constraints' => array(
                                    ),
                                    'defaults' => array(
                                        'action' => 'blog'
                                    )
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'post' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '[:post_id][/]',
                                            'constraints' => array(
                                                'post_id' => '[a-zA-Z0-9_-]+'
                                            ),
                                            'defaults' => array(
                                                'action' => 'post'
                                            )
                                        ),
                                        'may_terminate' => true,
                                    ),
                                ),
                            ),
                            'events' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'events[/]',
                                    'constraints' => array(
                                    ),
                                    'defaults' => array(
                                        'action' => 'events'
                                    )
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'event' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '[:event_id][/]',
                                            'constraints' => array(
                                                'event_id' => '[a-zA-Z0-9_-]+'
                                            ),
                                            'defaults' => array(
                                                'action' => 'event'
                                            )
                                        ),
                                        'may_terminate' => true,
                                    ),
                                ),
                            ),
                            'groups' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'groups[/]',
                                    'constraints' => array(
                                    ),
                                    'defaults' => array(
                                        'action' => 'groups'
                                    )
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'group' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '[:group_id][/]',
                                            'constraints' => array(
                                                'group_id' => '[a-zA-Z0-9_-]+'
                                            ),
                                            'defaults' => array(
                                                'action' => 'group'
                                            )
                                        ),
                                        'may_terminate' => true,
                                    ),
                                ),
                            ),
                            'friend' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'friend[/]',
                                    'constraints' => array(
                                    ),
                                    'defaults' => array(
                                        'action' => 'friend'
                                    )
                                ),
                                'may_terminate' => true,
                            ),
                            'album' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => 'album[/]',
                                    'constraints' => array(
                                    ),
                                    'defaults' => array(
                                        'action' => 'album'
                                    )
                                ),
                                'may_terminate' => true,
                            ),
                        ), //profile child_routes end
                    ), //profile end
                ), //user child_routes end
            ), //user end
            'messages' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/messages[/]',
                    'constraints' => array(
                    ),
                    'defaults' => array(
                        'controller' => 'MessagesController',
                        'action' => 'index',
                    ),
                ),
                'priority' => 2,
                'may_terminate' => true,
                'child_routes' => array(
                    'send' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'send[/][:id][/]',
                            'constraints' => array(
                                'id' => '[a-zA-Z0-9_-]+'
                            ),
                            'defaults' => array(
                                'action' => 'send'
                            ),
                        ),
                        'may_terminate' => true,
                    ), //conversation end
                    'conversation' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'conversation/[:id][/]',
                            'constraints' => array(
                                'id' => '[a-zA-Z0-9_-]+'
                            ),
                            'defaults' => array(
                                'action' => 'get'
                            ),
                        ),
                        'may_terminate' => true,
                    ), //conversation end
                    'remove' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'remove/[:id][/]',
                            'constraints' => array(
                                'id' => '[a-zA-Z0-9_-]+'
                            ),
                            'defaults' => array(
                                'action' => 'remove'
                            ),
                        ),
                        'may_terminate' => true,
                    ), //conversation end
                ), //message child_routes end
            ), //message end
        ), //routes end
    ),
    'controllers' => array(
        'invokables' => array(
            'PreregController' => 'Epic\Controller\PreregController',
            'PayController' => 'Epic\Controller\PayController',

            'Blog\Controller\BlogController' => 'Blog\Controller\BlogController',
            'Event\Controller\EventController' => 'Event\Controller\EventController',
            'Group\Controller\GroupController' => 'Group\Controller\GroupController',
            'Group\Controller\PostController' => 'Group\Controller\PostController',
            'Group\Controller\EventController' => 'Group\Controller\EventController',
            'User\Controller\FriendController' => 'User\Controller\FriendController',
            'User\Controller\UpgradeController' => 'User\Controller\UpgradeController',

            'HomeController' => 'Epic\Controller\HomeController',
            'PagesController' => 'Epic\Controller\PagesController',
            'LanguageController' => 'Epic\Controller\LanguageController',
            'LoginController' => 'Epic\Controller\LoginController',
            'ResetController' => 'Epic\Controller\ResetController',
            'RegisterController' => 'Epic\Controller\RegisterController',
            'UserController' => 'Epic\Controller\UserController',
            'AccountController' => 'Epic\Controller\AccountController',
            'FeedController' => 'Epic\Controller\FeedController',
            'MessagesController' => 'Epic\Controller\MessagesController',
            'MyController' => 'Epic\Controller\MyController',
            'BlogController' => 'Epic\Controller\BlogController',
            'EventController' => 'Epic\Controller\EventController',
            'GroupController' => 'Epic\Controller\GroupController',
            'ShareController' => 'Epic\Controller\ShareController',
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
        'banner_group' => array(
            'module' => 'Epic',
            'name' => 'banner_group',
            'title' => 'Group Page Banner',
            'path' => 'components/banner_group',
            'description' => 'Group Page Top Banner'
        ),
        'ad_home' => array(
            'module' => 'Epic',
            'name' => 'ad_home',
            'title' => 'Home Page Advertisement',
            'path' => 'components/ad_home',
            'description' => 'Home Page Advertisement'
        ),
        'ad_user' => array(
            'module' => 'Epic',
            'name' => 'ad_user',
            'title' => 'User Page Advertisement',
            'path' => 'components/ad_user',
            'description' => 'User Page Advertisement'
        ),
        'ad_setting' => array(
            'module' => 'Epic',
            'name' => 'ad_setting',
            'title' => 'Management/Setting Page Advertisement',
            'path' => 'components/ad_setting',
            'description' => 'Management/Setting Page Advertisement'
        ),
        'ad_event' => array(
            'module' => 'Epic',
            'name' => 'ad_event',
            'title' => 'Event Page Advertisement',
            'path' => 'components/ad_event',
            'description' => 'Event Page Advertisement'
        ),
        'ad_group' => array(
            'module' => 'Epic',
            'name' => 'ad_group',
            'title' => 'Group Page Advertisement',
            'path' => 'components/ad_group',
            'description' => 'Group Page Advertisement'
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

    'oauth' => array(
        'login_url_path' => '/home/'
    ),

    'contacts' => array(
        'invite_mail' => array(
            'subject' => 'Invite',
            'templatePath' => EVA_ROOT_PATH . '/website/Epic/view/',
            'template' => 'mail/invite',
        ),
    ),
);
