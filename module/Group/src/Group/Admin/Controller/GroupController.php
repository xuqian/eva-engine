<?php
namespace Group\Admin\Controller;

use Group\Form,
    Eva\Api,
    Eva\Mvc\Controller\RestfulModuleController,
    Eva\View\Model\ViewModel;

class GroupController extends RestfulModuleController
{
    protected $renders = array(
        'restPutGroup' => 'group/get',    
        'restPostGroup' => 'group/get',    
        'restDeleteGroup' => 'remove/get',    
    );

    public function restIndexGroup()
    {
        $query = $this->getRequest()->getQuery();
        $form = new Form\GroupSearchForm();
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
        $paginator = $itemModel->getPaginator();

        return array(
            'form' => $form,
            'items' => $items,
            'query' => $query,
            'paginator' => $paginator,
        );
    }

    public function restGetGroup()
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
                    'self' => array(
                        '*',
                    )
                ),
                'Tags' => array(
                    'self' => array(
                        '*',
                    ),
                ),
            ),
        ));

        if(isset($item['GroupFile'][0])){
            $item['GroupFile'] = $item['GroupFile'][0];
        }

        return array(
            'item' => $item,
        );
    }

    public function restPostGroup()
    {
        $request = $this->getRequest();
        $postData = $request->getPost();
        $form = new Form\GroupCreateForm();
        $form->useSubFormGroup()
            ->bind($postData);

        if ($form->isValid()) {
            $postData = $form->getData();
            $itemModel = Api::_()->getModel('Group\Model\Group');
            $user = \Core\Auth::getLoginUser('Auth_Admin');
            $postData['user_id'] = $user['id'];
            $groupId = $itemModel->setItem($postData)->createGroup();
            $this->flashMessenger()->addMessage('group-create-succeed');
            $this->redirect()->toUrl('/admin/group/' . $groupId);

        } else {

        }

        return array(
            'form' => $form,
            'post' => $postData,
        );
    }

    public function restPutGroup()
    {
        $postData = $this->params()->fromPost();
        $form = new Form\GroupEditForm();
        $form->useSubFormGroup()
            ->bind($postData);

        $flashMesseger = array();

        if ($form->isValid()) {
            $postData = $form->getData();
            $itemModel = Api::_()->getModel('Group\Model\Group');
            $groupId = $itemModel->setItem($postData)->saveGroup();

            $this->flashMessenger()->addMessage('group-edit-succeed');
            $this->redirect()->toUrl('/admin/group/' . $postData['id']);

        } else {
        }

        return array(
            'form' => $form,
            'item' => $postData,
        );
    }

    public function restDeleteGroup()
    {
        $postData = $this->params()->fromPost();
        $callback = $this->params()->fromPost('callback');

        $form = new Form\GroupDeleteForm();
        $form->bind($postData);
        if ($form->isValid()) {

            $postData = $form->getData();
            $itemModel = Api::_()->getModel('Group\Model\Group');
            $itemModel->setItem($postData)->removeGroup();

            if($callback){
                $this->redirect()->toUrl($callback);
            }

        } else {
            return array(
                'post' => $postData,
            );
        }
    }
}
