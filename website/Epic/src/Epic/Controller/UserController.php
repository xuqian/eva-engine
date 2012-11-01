<?php
namespace Epic\Controller;

use Eva\Api;
use Eva\Mvc\Controller\ActionController;
use Eva\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Core\Auth;

class UserController extends ActionController
{
    protected $user;

    public function getUser()
    {
        if($this->user){
            return $this->user;
        }

        $userId = $this->getEvent()->getRouteMatch()->getParam('id');
        if(!$userId){
            return array();
        }
        $userModel = Api::_()->getModel('User\Model\User');
        $user = $userModel->getUser($userId)->toArray(array(
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
            ),
        ));
        return $this->user = $user;
    }

    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        $events = $this->getServiceLocator()->get('Application')->getEventManager();
        $events->attach(MvcEvent::EVENT_RENDER, array($this, 'setUserToView'));
    }

    public function setUserToView($event)
    {
        $user = $this->getUser();
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

        $form = new \User\Form\UserSearchForm();
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
        $user = $this->getUser();
        $itemModel = Api::_()->getModel('Activity\Model\Activity');

        $feedMap = array(
            'self' => array(
                '*',
                'getContentHtml()',
            ),
            'join' => array(
                'File' => array(
                    'self' => array(
                        '*',
                        'getThumb()',
                    )
                ),
            ),
        );
        $activityList = $itemModel->getUserActivityList($user['id'], true)->getActivityList($feedMap);

        $userList = array();
        $userList = $itemModel->getUserList()->toArray();

        $forwardActivityList = $itemModel->getForwardActivityList()->getActivityList($feedMap);
        
        $activityList = $itemModel->combineList($activityList, $userList, 'User', array('user_id' => 'id'));
        $items = $itemModel->combineList($activityList, $forwardActivityList, 'ForwardActivity', array('reference_id' => 'id'));


        $viewModel = new ViewModel(array(
            'user' => $user,
            'items' => $items,
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

        $user = $this->getUser();
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

        $view = new ViewModel(array(
            'item' => $item,
        ));
        return $view;
    }

    public function friendAction()
    {
    }

    public function albumAction()
    {
    }

    public function groupAction()
    {
    }

    public function eventAction()
    {
    }

    public function registerAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $item = $request->getPost();

            $oauth = new \Oauth\OauthService();
            $oauth->setServiceLocator($this->getServiceLocator());
            $oauth->initByAccessToken();
            $accessToken = $oauth->getAdapter()->getAccessToken();

            $form = $accessToken ? new \User\Form\QuickRegisterForm : new \User\Form\RegisterForm();
            $form->bind($item);
            if ($form->isValid()) {
                $callback = $this->params()->fromPost('callback');
                $callback = $callback ? $callback : '/';

                $item = $form->getData();
                $itemModel = Api::_()->getModel('User\Model\Register');
                $itemModel->setItem($item)->register();
                $this->redirect()->toUrl($callback);
            } else {
            }
            return array(
                'token' => $accessToken,
                'form' => $form,
                'item' => $item,
            );
        }
    }
}
