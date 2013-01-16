<?php
namespace Epic\Controller;

use Eva\Api;
use Eva\Mvc\Controller\ActionController;
use Eva\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Core\Auth;
use Oauth\OauthService;

class UserController extends ActionController
{
    protected $user;

    public function userAction()
    {
        if($this->user){
            return $this->user;
        }

        $userId = $this->getEvent()->getRouteMatch()->getParam('id');
        if(!$userId){
            return array();
        }
        $userModel = Api::_()->getModel('User\Model\User');
        $user = $userModel->getUser($userId);
        if(!$user){
            return array();
        }
        $user = $user->toArray(array(
            'self' => array(
                '*',
            ),
            'join' => array(
                'Profile' => array(
                    '*'
                ),
                'Roles' => array(
                    '*'
                ),
                'FriendsCount' => array(
                ),
                'Tags' => array(
                    '*'
                ),
            ),
            'proxy' => array(
                'User\Item\User::Avatar' => array(
                    '*',
                    'getThumb()'
                ),
                'User\Item\User::Header' => array(
                    '*',
                    'getThumb()'
                ),
                'Oauth\Item\Accesstoken::Oauth' => array(
                    '*'
                ),
                'Blog\Item\Post::UserPostCount' => array(
                ),
                'Event\Item\EventUser::EventCount' => array(
                ),
            ),
        ));
        return $this->user = $user;
    }

    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        $events = $this->getServiceLocator()->get('Application')->getEventManager();
        $events->attach(MvcEvent::EVENT_RENDER, array($this, 'setUserToView'), 100);
    }

    public function setUserToView($event)
    {
        $user = $this->userAction();
        $viewModel = $this->getEvent()->getViewModel();
        $viewModel->setVariables(array(
            'user' => $user,
            'viewAsGuest' => 1
        ));
        $viewModelChildren = $viewModel->getChildren();
        foreach($viewModelChildren as $childViewModel){
            $childViewModel->setVariables(array(
                'user' => $user,
                'viewAsGuest' => 1
            ));
        }
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $query = $request->getQuery();

        return array(
            'query' => $query,
        ); 
    }

    public function listAction()
    {
        $request = $this->getRequest();
        $query = $request->getQuery();

        $form = new \Epic\Form\UserSearchForm();
        $form->bind($query)->isValid();
        $selectQuery = $form->getData();

        $itemModel = Api::_()->getModel('User\Model\User');
        if(!$selectQuery){
            $selectQuery = array(
                'page' => 1
            );
        }
        $items = $itemModel->setItemList($selectQuery)->getUserList();
        $items = $items->toArray(array(
            'self' => array(
            ),
            'join' => array(
                'Profile' => array(
                    'self' => array(
                        '*'
                    ),
                ),
            ),
            'proxy' => array(
                'User\Item\User::Avatar' => array(
                    '*',
                    'getThumb()'
                ),
                'Event\Item\EventUser::EventCount' => array(
                ),
            ),
        ));
        $paginator = $itemModel->getPaginator();

        $user = Auth::getLoginUser();
        $followList = array();
        if($user) {
            $followModel = Api::_()->getModel('Activity\Model\Follow');
            $followList = $followModel->setUserList($items)->setItemList(array(
                'follower_id' => $user['id']
            ))->getFollowList()->toArray();
        }

        $items = $itemModel->combineList($items, $followList, 'Follow', array('id' => 'user_id'));

        return array(
            'form' => $form,
            'items' => $items,
            'query' => $query,
            'paginator' => $paginator,
        );
    }

    public function getAction()
    {
        $user = $this->userAction();

        list($items, $paginator) = $this->forward()->dispatch('FeedController', array(
            'action' => 'index',
            'user_id' => $user['id'],
            'author_id' => $user['id'],
        ));

        $viewModel = new ViewModel(array(
            'user' => $user,
            'items' => $items,
            'paginator' => $paginator,
        ));
        $viewModel->setTemplate('epic/home/index');

        return $viewModel;
    }

    public function blogAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $query = array(
            'page' => $page,
        );

        $user = $this->userAction();
        $itemListQuery = array_merge(array(
            'user_id' => $user['id'],
            'order' => 'iddesc',
        ), $query);
        $itemModel = Api::_()->getModel('Blog\Model\Post');
        $items = $itemModel->setItemList($itemListQuery)->getPostList(array(
            'self' => array(
                '*',
            ),
            'join' => array(
                'Text' => array(
                    'self' => array(
                        '*',
                        'getContentHtml()',
                    ),
                ),
            ),
            'proxy' => array(
                'File\Item\File::PostCover' => array(
                    'self' => array(
                        '*',
                        'getThumb()',
                    ),
                )
            ),
        ));
        $userList = $itemModel->getUserList()->toArray();
        $items = $itemModel->combineList($items, $userList, 'User', array('user_id' => 'id'));

        $paginator = $itemModel->getPaginator();
        return array(
            'items' => $items,
            'query' => $query,
            'paginator' => $paginator,
        );
    }

    public function postAction()
    {
        $id = $this->params('post_id');
        $itemModel = Api::_()->getModel('Blog\Model\Post');
        $item = $itemModel->getPost($id, array(
            'self' => array(
                '*',
            ),
            'join' => array(
                'Text' => array(
                    'self' => array(
                        '*',
                        'getContentHtml()',
                    ),
                ),
                'Categories' => array(
                ),
            ),
            'proxy' => array(
                'File\Item\File::PostCover' => array(
                    'self' => array(
                        '*',
                        'getThumb()',
                    )
                )
            ),
        ));
        if(!$item || $item['status'] != 'published'){
            $item = array();
            $this->getResponse()->setStatusCode(404);
        }

        if($item){
            $item['Prev'] = $itemModel->getItem()->getDataClass()->where(array(
                "id < {$item['id']}"
            ))
            ->where(array("status" => "published"))
            ->order('id DESC')->find('one');

            $item['Next'] = $itemModel->getItem()->getDataClass()->where(array(
                "id > {$item['id']}"
            ))
            ->where(array("status" => "published"))
            ->order('id ASC')->find('one');
        }

        $comments = array();
        if($item) {
            $commentModel = Api::_()->getModel('Blog\Model\Comment');
            $comments = $commentModel->setItemList(array(
                'post_id' => $item['id'],
                'noLimit' => true,
            ))->getCommentList(array(
                'self' => array(
                    '*',
                    'getContentHtml()',
                ),
                'proxy' => array(
                    'Blog\Item\Comment::User' => array(
                        'self' => array(
                            '*',
                            'getThumb()',
                        ),
                        'proxy' => array(
                            'User\Item\User::Avatar' => array(
                                '*',
                                'getThumb()'
                            ),
                        ),
                    ),
                ),
            ));
        }

        $view = new ViewModel(array(
            'item' => $item,
            'comments' => $comments,
        ));
        return $view;
    }

    public function friendAction()
    {
    }

    public function albumsAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $query = array(
            'page' => $page,
        );

        $user = $this->userAction();
        $itemListQuery = array_merge(array(
            'user_id' => $user['id'],
            'order' => 'timedesc',
        ), $query);
        $itemModel = Api::_()->getModel('Album\Model\Album');
        $items = $itemModel->setItemList($itemListQuery)->getAlbumList();
        $items = $items->toArray(array(
            'self' => array(
                '*',
            ),  
            'join' => array(
                'File' => array(
                    'self' => array(
                        '*',
                        'getThumb()',
                    )
                ),
            ),
        ));

        $paginator = $itemModel->getPaginator();
        return array(
            'items' => $items,
            'query' => $query,
            'paginator' => $paginator,
        );
    }

    public function groupAction()
    {
        $id = $this->params('group_id');
        $itemModel = Api::_()->getModel('Group\Model\Group'); 
        $item = $itemModel->getGroup($id, array(
            'self' => array(
                '*',
            ),
            'join' => array(
                'Text' => array(
                    'self' => array(
                        '*',
                    ),
                ),
                'File' => array(
                    'self' => array(
                        '*',
                        'getThumb()',
                    )
                ),
            ),
        ));

        if(!$item || $item['status'] != 'active'){
            $item = array();
            $this->getResponse()->setStatusCode(404);
        }

        $view = new ViewModel(array(
            'item' => $item,
        ));
        return $view; 
    }

    public function groupsAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $query = array(
            'page' => $page,
        );

        $user = $this->userAction();
        $itemListQuery = array_merge(array(
            'user_id' => $user['id'],
            'order' => 'timedesc',
        ), $query);
        $itemModel = Api::_()->getModel('Group\Model\GroupUser');
        $items = $itemModel->setItemList($itemListQuery)->getGroupUserList();
        $items = $items->toArray(array(
            'self' => array(
                '*',
            ),
            'join' => array(
                'Group' => array(
                    'self' => array(
                        '*',
                    ),  
                    'join' => array(
                        'Text' => array(
                            'self' => array(
                                '*',
                            ),
                        ),
                        'File' => array(
                            'self' => array(
                                '*',
                                'getThumb()',
                            )
                        ),
                    ),
                ),
            ),
        ));

        $paginator = $itemModel->getPaginator();
        return array(
            'items' => $items,
            'query' => $query,
            'paginator' => $paginator,
        );
    }

    public function eventAction()
    {
        $id = $this->params('event_id');
        $itemModel = Api::_()->getModel('Event\Model\Event'); 
        $item = $itemModel->getEventdata($id, array(
            'self' => array(
                '*',
            ),
            'join' => array(
                'Text' => array(
                    'self' => array(
                        '*',
                    ),
                ),
                'File' => array(
                    'self' => array(
                        '*',
                        'getThumb()',
                    )
                ),
            ),
        ));

        if(!$item || ($item['eventStatus'] != 'finished' && $item['eventStatus'] != 'active')){
            $item = array();
            $this->getResponse()->setStatusCode(404);
        }

        $view = new ViewModel(array(
            'item' => $item,
        ));
        return $view; 
    }

    public function eventsAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $query = array(
            'page' => $page,
        );

        $user = $this->userAction();
        $itemListQuery = array_merge(array(
            'user_id' => $user['id'],
            'order' => 'timedesc',
        ), $query);
        $itemModel = Api::_()->getModel('Event\Model\EventUser');
        $items = $itemModel->setItemList($itemListQuery)->getEventUserList();
        $items = $items->toArray(array(
            'self' => array(
                '*',
            ),
            'join' => array(
                'Event' => array(
                    'self' => array(
                        '*',
                    ),  
                    'join' => array(
                        'Text' => array(
                            'self' => array(
                                '*',
                            ),
                        ),
                        'File' => array(
                            'self' => array(
                                '*',
                                'getThumb()',
                            )
                        ),
                    ),
                ),
            ),
        ));

        $paginator = $itemModel->getPaginator();
        return array(
            'items' => $items,
            'query' => $query,
            'paginator' => $paginator,
        );
    }

    public function registerAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {

            $item = $request->getPost();

            $oauth = new \Oauth\OauthService();
            $accessToken = array();
            if($oauth->getStorage()->getAccessToken()) {
                $oauth->setServiceLocator($this->getServiceLocator());
                $oauth->initByAccessToken();
                $accessToken = $oauth->getAdapter()->getAccessToken();
            }

            $form = $accessToken ? new \User\Form\QuickRegisterForm : new \Epic\Form\RegisterForm();
            $form->bind($item);
            if ($form->isValid()) {
                $callback = $this->params()->fromPost('callback');
                $callback = $callback ? $callback : '/';

                $item = $form->getData();
                $itemModel = Api::_()->getModel('User\Model\Register');
                $itemModel->setItem($item)->register();

                $userItem = $itemModel->getItem();
                $codeItem = $itemModel->getItem('User\Item\Code');
                $mail = new \Core\Mail();
                $mail->getMessage()
                    ->setSubject("Please Confirm Your Email Address")
                    ->setData(array(
                        'user' => $userItem,
                        'code' => $codeItem,
                    ))
                    ->setTo($userItem->email, $userItem->userName)
                    ->setTemplatePath(Api::_()->getModulePath('User') . '/view/')
                    ->setTemplate('mail/active');
                $mail->send();

                $this->redirect()->toUrl($callback);
            } else {
            }
            return array(
                'token' => $accessToken,
                'form' => $form,
                'item' => $item,
            );
        } else {
            return array(
                'item' => $this->getRequest()->getQuery()
            );
        }
    }
}
