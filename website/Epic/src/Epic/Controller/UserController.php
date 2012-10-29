<?php
namespace Epic\Controller;

use Eva\Api;
use Eva\Mvc\Controller\ActionController;
use Eva\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;

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
        $user = $userModel->getUser($userId)->toArray();
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
                '*',
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
        return array(
            'form' => $form,
            'items' => $items,
            'query' => $query,
            'paginator' => $paginator,
        );
    }

    public function getAction()
    {
        $viewModel = $this->forward()->dispatch('HomeController', array(
            'action' => 'index',
        )); 
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
            $form = new \User\Form\RegisterForm();
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
                'form' => $form,
                'item' => $item,
            );
        }
    }
}
