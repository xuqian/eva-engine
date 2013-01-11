<?php
namespace Epic\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel,
    Zend\View\Model\JsonModel;
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
        
        $categoryModel = Api::_()->getModel('Group\Model\Category');
        $categories = $categoryModel->setItemList(array('noLimit' => true))->getCategoryList();
        $categories = $categories->toArray();
        
        if ($query['category']) {
            $category = $categoryModel->getCategory($query['category']);
        } else {
            $category = array(
                'id' => '',
                'urlName' => '',
                'categoryName' => 'Hot',
            );
        }

        return array(
            'form' => $form,
            'items' => $items,
            'query' => $query,
            'categories' => $categories,
            'category' => $category,
            'paginator' => $paginator,
        );   
    }

    public function getAction()
    {
        $id = $this->params('id');

        list($item, $members) = $this->groupAction();
        list($posts, $paginator) = $this->blogAction($item['id']);

        $view = new ViewModel(array(
            'item' => $item,
            'members' => $members,
            'posts' => $posts,
            'paginator' => $paginator,
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
                'PostCount' => array(
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
                        'self' => array(
                            '*'
                        ),
                        'proxy' => array(
                            'User\Item\User::Avatar' => array(
                                '*',
                                'getThumb()'
                            ),
                        ),
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
        $form = new \Epic\Form\GroupCreateForm();
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
            $form = new \Epic\Form\GroupEditForm();
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
    
    public function blogAction($groupId)
    {
        if (!$groupId) {
            return array();
        }
        
        $page = $this->params()->fromQuery('page', 1);
        $rows = $this->params()->fromQuery('rows', 20);
        $order = $this->params()->fromQuery('order', 'timedesc');
        
        $this->changeViewModel('json');
        
        $itemModel = Api::_()->getModel('Group\Model\Post'); 
        $items = $itemModel->setItemList(array(
            'inGroup' => true,
            'group_id' => $groupId,
            'page' => $page,
            'rows' => $rows,
            'order' => $order
        ))->getPostList(array(
            'self' => array(
                '*', 
            ),
            'join' => array(
                'Group' => array(
                    '*'
                ),
            ),
        ));

        if (count($items) > 0) {
            foreach ($items as $key=>$item) {
                if (count($item['Group']) > 0) {
                    unset($items[$key]['File'][0]);
                    $items[$key]['Group'] = $item['Group'][0];
                } else {
                    unset($items[$key]['Group']);
                }
            }
        }
        
        $paginator = $itemModel->getPaginator();
        $paginator = $paginator ? $paginator : null;

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

        return array($items, $paginator); 

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

        $postView = $this->forward()->dispatch('UserController', array(
            'action' => 'post',
            'post_id' => $postId,
        ));
        
        list($item, $members) = $this->groupAction();
        
        $viewModel->setVariables(array(
            'item' => $item,
            'post' => $postView->item,
            'comments' => $postView->comments,
            'members' => $members,
        ));
        
        return $viewModel;
    }

    public function sendmailAction()
    {
        list($item, $members) = $this->groupAction();
        
        $viewModel = new ViewModel();

        $viewModel->setVariables(array(
            'item' => $item,
            'members' => $members,
        ));

        $user = Auth::getLoginUser(); //Could not get user info after form valid

        if ($user['id'] != $item['user_id']) {
            exit;
        }

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $postData = $request->getPost();
            
            $userIds = $postData['user_id'];

            if (!$postData['user_id']) {
                exit;
            }

            

            $form = new \Core\Form\SendEmailForm();
            $form->bind($postData);
            if ($form->isValid()) {
                $data = $form->getData();
                $file = array();
                if($form->getFileTransfer()->isUploaded()) {
                    $form->getFileTransfer()->receive();
                    $files = $form->getFileTransfer()->getFileInfo();
                    $file = $files['attachment'];
                }

                $userModel = Api::_()->getModel('User\Model\User');
                $users = $userModel->setItemList(array(
                    'noLimit' => true,
                    'id' => $userIds,
                ))->getUserList()->toArray();
                
                $mail = new \Core\Mail();
                $message = $mail->getMessage();
                
                foreach ($users as $user) {
                    $message->addBcc($user['email']);
                }

                $message->setSubject($data['subject'])
                    ->setBody($data['content']);
                
                if($file['tmp_name']){
                    $message->addAttachment($file['tmp_name']);
                }
                $mail->send();

                return $this->redirect()->toUrl('/group/' . $item['groupKey']);

            } else {
            }
        } 

        return $viewModel; 
    }

    public function eventAction()
    {
        list($item, $members) = $this->groupAction();
        $groupId = $item['id'];

        $viewModel = new ViewModel();
        $viewModel->setTemplate('epic/group/event-list');

        $page = $this->params()->fromQuery('page', 1);
        $rows = $this->params()->fromQuery('rows', 10);
        $order = $this->params()->fromQuery('order', 'timedesc');

        $eventView = $this->forward()->dispatch('EventController', array(
            'action' => 'list',
            'group_id' => $groupId,
            'order' => $order,
        )); 

        $viewModel->setVariables(array(
            'item' => $item,
            'members' => $members,
            'items' => $eventView->items,
            'paginator' => $eventView->paginator,
            'query' => $eventView->query,
        ));

        return $viewModel; 
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

    public function postAction()
    {
        $itemModel = Api::_()->getModel('Group\Model\Post'); 
        $items = $itemModel->setItemList(array(
            'inGroup' => true,
            'group_id' => 1,
            'order' => 'commentdesc'
        ))->getPostList(array(
            'self' => array(
               '*', 
            )
        ));
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

        return array(
            'items' => $items
        );
    }
}
