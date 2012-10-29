<?php
namespace Epic\Controller;

use Eva\Api;
use Eva\Mvc\Controller\ActionController;
use Eva\View\Model\ViewModel;
use Core\Auth;
use Epic\Form;

class AccountController extends ActionController
{

    public function profileAction()
    {
        $request = $this->getRequest();
        $form = array();

        if ($request->isPost()) {
            $item = $request->getPost();
            $form = new Form\AccountEditForm();
            $form->useSubFormGroup();
            $form->bind($item);
            if ($form->isValid()) {
                $callback = $this->params()->fromPost('callback');
                $callback = $callback ? $callback : '/';

                $item = $form->getData();
                $itemModel = Api::_()->getModel('User\Model\User');
                $itemModel->setItem($item)->saveUser();
                $this->redirect()->toUrl($callback);
            } else {
                $item = $form->getData();
            }
        } else {
            $user = Auth::getLoginUser();
            $itemModel = Api::_()->getModel('User\Model\User');
            $item = $itemModel->getUser($user['id']);

            $item = $item->toArray(array(
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
                ),
            ));
        }
        return array(
            'item' => $item,
            'form' => $form,
        );
    }

    public function settingAction()
    {
        $request = $this->getRequest();
        $form = array();

        if ($request->isPost()) {
            $item = $request->getPost();
            $form = new Form\AccountEditForm();
            $form->useSubFormGroup();
            $form->bind($item);
            if ($form->isValid()) {
                $callback = $this->params()->fromPost('callback');
                $callback = $callback ? $callback : '/';

                $item = $form->getData();
                $itemModel = Api::_()->getModel('User\Model\User');
                $itemModel->setItem($item)->saveUser();
                $this->redirect()->toUrl($callback);
            } else {
                $item = $form->getData();
            }
        } else {
            $user = Auth::getLoginUser();
            $itemModel = Api::_()->getModel('User\Model\User');
            $item = $itemModel->getUser($user['id']);

            $item = $item->toArray(array(
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
                ),
            ));
        }
        return array(
            'item' => $item,
            'form' => $form,
        );
    }

    public function membershipAction()
    {
    
    }

}
