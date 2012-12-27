<?php
namespace Epic\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;
use Core\Auth;
use Group\Form;

class GroupController extends ActionController
{
    protected $group;
    
    protected $post;
    
    protected $eventData;
   
    public function indexAction()
    {
        return $this->listAction();
    }

    public function listAction()
    {
        $request = $this->getRequest();
        $query = $request->getQuery();

        $form = new \Epic\Form\GroupSearchForm();
        $form->bind($query)->isValid();
        $selectQuery = $form->getData();

        $itemModel = Api::_()->getModel('Group\Model\Group');
        if(!$selectQuery){
            $selectQuery = array(
                'page' => 1
            );
        }
        $selectQuery['status'] = 'active';
        $items = $itemModel->setItemList($selectQuery)->getGroupList();
        $items = $items->toArray(array(
            'self' => array(
            ),
            'join' => array(
                'Count' => array(
                    '*',
                ),
            ),
        ));
        $paginator = $itemModel->getPaginator();

        $user = Auth::getLoginUser();
        $joinList = array();
        if($user) {
            $joinModel = Api::_()->getModel('Group\Model\GroupUser');
            $joinList = $joinModel->setItemList(array(
                'user_id' => $user['id']
            ))->getGroupUserList()->toArray();
        }

        $items = $itemModel->combineList($items, $joinList, 'Join', array('id' => 'group_id'));


        //Public User Area
        $this->forward()->dispatch('UserController', array(
            'action' => 'user',
            'id' => $user['id'],
        ));

        return array(
            'form' => $form,
            'items' => $items,
            'query' => $query,
            'paginator' => $paginator,
        );   
    }

    public function getAction()
    {
        $id = $this->params('id');

        list($item,$members) = $this->groupAction();

        $view = new ViewModel(array(
            'item' => $item,
            'members' => $members,
        ));
        return $view; 
    }

    public function groupAction()
    {
        if($this->group){
            return $this->group;
        }   
    
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        if(!$id){
            return array();
        }

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
                'Category' => array(
                    '*'
                ),
                'Count' => array(
                    '*',
                ),
            ),
        ));

        if(!$item || $item['status'] != 'active'){
            $item = array();
            $this->getResponse()->setStatusCode(404);
        }
        $user = Auth::getLoginUser(); 
        //Public User Area
        $this->forward()->dispatch('UserController', array(
            'action' => 'user',
            'id' => $user['id'],
        ));

        if($user) {
            $joinModel = Api::_()->getModel('Group\Model\GroupUser');
            $joinList = $joinModel->setItemList(array(
                'group_id' => $item['id'],
                'user_id' => $user['id']
            ))->getGroupUserList()->toArray();
        
            if (count($joinList) > 0) {
                $item['Join'] = $joinList[0];
            }
        }

        $memberModel = Api::_()->getModel('Group\Model\GroupUser'); 
        $members = $memberModel->setItemList(array('group_id' => $item['id'], 'noLimit' => true))->getGroupUserList();
        $members = $members->toArray(
            array(
                'self' => array(
                    '*',
                ),
                'join' => array(
                    'User' => array(
                        '*',
                    ),
                ),
            )
        );
        
        $this->group = $item;
        
        return array($item, $members);
    }

    public function removeAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {

            $postData = $this->params()->fromPost();
            $callback = $this->params()->fromPost('callback');

            $form = new \Group\Form\GroupDeleteForm();
            $form->bind($postData);
            if ($form->isValid()) {

                $postData = $form->getData();
                $itemModel = Api::_()->getModel('Group\Model\Group');
                $itemModel->setItem($postData)->removeGroup();
                $callback = $callback ? $callback : '/my/group/';
                $this->redirect()->toUrl($callback);

            } else {
                return array(
                    'post' => $postData,
                );
            }

        } else {
            $id = $this->params('id');
            $itemModel = Api::_()->getModel('Group\Model\Group');
            $item = $itemModel->getGroup($id)->toArray();

            $user = Auth::getLoginUser(); 
            //Public User Area
            $this->forward()->dispatch('UserController', array(
                'action' => 'user',
                'id' => $user['id'],
            ));

            return array(
                'callback' => $this->params()->fromQuery('callback'),
                'item' => $item,
            );

        }

    }

    public function createAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return;
        }

        $postData = $request->getPost();
        $callback = $this->params()->fromPost('callback');
        $form = new Form\GroupCreateForm();
        $form->useSubFormGroup()
            ->bind($postData);

        if ($form->isValid()) {
            $postData = $form->getData();
            $postData['status'] = 'active';
            $itemModel = Api::_()->getModel('Group\Model\Group');
            $groupId = $itemModel->setItem($postData)->createGroup();
            $callback = $callback ? $callback : '/groups/edit/' . $groupId;
            $this->redirect()->toUrl($callback);
        } else {
            $user = Auth::getLoginUser(); 
            //Public User Area
            $this->forward()->dispatch('UserController', array(
                'action' => 'user',
                'id' => $user['id'],
            ));
        }

        return array(
            'form' => $form,
            'post' => $postData,
        );
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $viewModel = new ViewModel();
        $viewModel->setTemplate('epic/group/create');
        if ($request->isPost()) {
            $postData = $request->getPost();
            $callback = $this->params()->fromPost('callback');
            $form = new Form\GroupEditForm();
            $form->useSubFormGroup()
                ->bind($postData);

            if ($form->isValid()) {
                $postData = $form->getData();
                $itemModel = Api::_()->getModel('Group\Model\Group');
                $groupId = $itemModel->setItem($postData)->saveGroup();
                $callback = $callback ? $callback : '/groups/edit/' . $groupId;
                $this->redirect()->toUrl($callback);

            } else {
            }

            $viewModel->setVariables(array(
                'form' => $form,
                'item' => $postData,
            ));
        } else {
            $id = $this->params('id');
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
                    'Category' => array(
                        '*'
                    ),
                ),
            ));
            if(isset($item['GroupFile'][0])){
                $item['GroupFile'] = $item['GroupFile'][0];
            }

            $user = Auth::getLoginUser(); 
            //Public User Area
            $this->forward()->dispatch('UserController', array(
                'action' => 'user',
                'id' => $user['id'],
            ));

            $viewModel->setVariables(array(
                'item' => $item,
            ));
        }

        return $viewModel;
    }

    public function postCreateAction()
    {
        $request = $this->getRequest();
        $viewModel = new ViewModel();
        
        list($item, $members) = $this->groupAction();

        return array(
            'item' => $item,
            'members' => $members,
        );   
    }
    
    public function postEditAction()
    {
        $request = $this->getRequest();
        $viewModel = new ViewModel();
        $viewModel->setTemplate('epic/group/post-create');
        
        $postId = $this->getEvent()->getRouteMatch()->getParam('post_id');

        $postView = $this->forward()->dispatch('BlogController', array(
            'action' => 'edit',
            'id' => $postId,
        ));
        
        list($item, $members) = $this->groupAction();
        
        $viewModel->setVariables(array(
            'item' => $item,
            'post' => $postView->item,
            'members' => $members,
        ));
    
        return $viewModel;
    }

    public function postGetAction()
    {
        $request = $this->getRequest();
        $viewModel = new ViewModel();
        
        $postId = $this->getEvent()->getRouteMatch()->getParam('post_id');

        $postView = $this->forward()->dispatch('BlogController', array(
            'action' => 'edit',
            'id' => $postId,
        ));
        
        list($item, $members) = $this->groupAction();
        
        $viewModel->setVariables(array(
            'item' => $item,
            'post' => $postView->item,
            'members' => $members,
        ));
        
        return $viewModel;
    }
    
    public function eventAction()
    {
        $this->changeViewModel('json');
        $query = $this->getRequest()->getQuery();
        $form = new \Epic\Form\GroupSearchForm();
        $form->bind($query);
        if($form->isValid()){
            $query = $form->getData();
        } else {
            return array(
                'form' => $form,
                'items' => array(),
            );
        }
        
        $itemModel = Api::_()->getModel('Group\Model\Group');
        $items = $itemModel->setItemList($query)->getGroupList();
     
        $items = $items->toArray(array(
            'self' => array(
                '*'
            ),
            'join' => array(
                'Count' => array(
                    '*',
                ),
                'File' => array(
                    'self' => array(
                        '*',
                        'getThumb()',
                    )
                ),
            ), 
        ));
        
        if (count($items) > 0) {
            foreach ($items as $key=>$item) {
                if (count($item['File']) > 0) {
                    unset($items[$key]['File'][0]);
                    $items[$key]['File'] = $item['File'][0];
                } else {
                    unset($items[$key]['File']);
                }
            }
        }

        $paginator = $itemModel->getPaginator();
        $paginator = $paginator ? $paginator->toArray() : null;

        if(Api::_()->isModuleLoaded('User')){
            $userList = array();
            $userList = $itemModel->getUserList(array(
                'columns' => array(
                    'id',
                    'userName',
                    'email',
                ),
            ))->toArray(array(
                'self' => array(
                    'getEmailHash()',
                ),
            ));
            $items = $itemModel->combineList($items, $userList, 'User', array('user_id' => 'id'));
        }

        return new JsonModel(array(
            'items' => $items,
            'paginator' => $paginator,
        )); 
    }

    public function eventCreateAction()
    {
        $request = $this->getRequest();
        $viewModel = new ViewModel();
        
        list($item, $members) = $this->groupAction();

        return array(
            'item' => $item,
            'members' => $members,
        );   
    }

    public function eventEditAction()
    {
        $request = $this->getRequest();
        $viewModel = new ViewModel();
        $viewModel->setTemplate('epic/group/event-create');
        
        $eventId = $this->getEvent()->getRouteMatch()->getParam('event_id');

        $eventView = $this->forward()->dispatch('EventController', array(
            'action' => 'get',
            'id' => $eventId,
        ));
        /*
        $viewModel->addChild($eventView, 'event');
        */
        list($item, $members) = $this->groupAction();
        
        $viewModel->setVariables(array(
            'item' => $item,
            'event' => $eventView->item,
            'members' => $members,
        ));
    
        return $viewModel;
    }

    public function eventGetAction()
    {
        $request = $this->getRequest();
        $viewModel = new ViewModel();
        $eventId = $this->getEvent()->getRouteMatch()->getParam('event_id');

        $eventView = $this->forward()->dispatch('EventController', array(
            'action' => 'get',
            'id' => $eventId,
        ));
        /*
        $viewModel->addChild($eventView, 'event');
        */
        list($item, $members) = $this->groupAction();
        
        $viewModel->setVariables(array(
            'item' => $item,
            'event' => $eventView->item,
            'items' => $eventView->items,
            'eventMembers' => $eventView->members,
            'members' => $members,
            'paginator' => $eventView->paginator,
        ));
    

        return $viewModel;
    }
}
