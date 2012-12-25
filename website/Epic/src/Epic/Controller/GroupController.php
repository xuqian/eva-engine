<?php
namespace Epic\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;
use Core\Auth;
use Group\Form;

class GroupController extends ActionController
{
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
        $view = new ViewModel(array(
            'item' => $item,
        ));
        return $view; 
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
}
