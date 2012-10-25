<?php
namespace Epic\Controller;

use Eva\Api;
use Eva\Mvc\Controller\ActionController;
use Eva\View\Model\ViewModel;
use Core\Auth;

class AccountController extends ActionController
{

    public function profileAction()
    {
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
                'Account' => array('*'),
            ),
        ));
        return array(
            'item' => $item,
        );
    }

    public function getAction()
    {
        $viewModel = $this->forward()->dispatch('HomeController', array(
            'action' => 'index',
        )); 
        $viewModel->setVariables(array(
            'viewAsGuest' => 1
        ));
        return $viewModel;
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
