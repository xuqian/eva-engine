<?php
namespace Epic\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;
use Core\Auth;

class MyController extends ActionController
{

    public function indexAction()
    {
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

    public function blogAction()
    {
        $user = Auth::getLoginUser();
        $viewModel = $this->forward()->dispatch('UserController', array(
            'action' => 'blog',
            'id' => $user['userName'],
        )); 
        $viewModel->setVariables(array(
            'viewAsOwner' => 1
        ));
        return $viewModel;
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
