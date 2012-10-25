<?php
namespace Epic\Controller;

use Eva\Mvc\Controller\ActionController;
use Eva\View\Model\ViewModel;
use Eva\Api;
use Core\Auth;

class LoginController extends ActionController
{
    protected $addResources = array(
    );

    public function logoutAction()
    {
        $callback = $this->params()->fromQuery('callback');
        if(!$callback && $this->getRequest()->getServer('HTTP_REFERER')){
            $callback = $this->getRequest()->getServer('HTTP_REFERER');
        }
        $callback = $callback ? $callback : '/';
        $model = new ViewModel();
        $auth = Auth::factory();
        $auth->getAuthStorage()->clear();
        $this->cookie()->clear('realm');
        return $this->redirect()->toUrl($callback);
    }

    public function indexAction()
    {
        $this->layout('layout/login');

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return;
        }
            
        $item = $request->getPost();
        $form = new \User\Form\LoginForm();
        $form->bind($item);
        if ($form->isValid()) {
            $callback = $this->params()->fromPost('callback');
            $callback = $callback ? $callback : '/home';

            $item = $form->getData();
            $itemModel = Api::_()->getModel('User\Model\Login');
            $loginResult = $itemModel->setItem($item)->login();

            if($item['rememberMe']){
                $tokenString = $itemModel->createToken();
                //Cookie expired after 60 days
                $this->cookie()->crypt(false)->write('realm', $tokenString, 3600 * 24 * 60);
            }
            $this->redirect()->toUrl($callback);
        } else {
            $item = $form->getData();
        }
        return array(
            'form' => $form,
            'item' => $item,
        );
    }

    public function autoAction()
    {
        $callback = $this->params()->fromQuery('callback', '/home');
        $realm = $this->cookie()->crypt(false)->read('realm');

        if(!$realm){
            $this->cookie()->clear('realm');
            return $this->redirect()->toUrl($callback);
        }

        $itemModel = Api::_()->getModel('User\Model\Login');
        $loginResult = $itemModel->loginByToken($realm);
        if($loginResult->isValid()){
            $tokenString = $itemModel->refreshToken($realm);
            //Cookie expired after 60 days
            $this->cookie()->crypt(false)->write('realm', $tokenString, 3600 * 24 * 60);
        } else {
            $this->cookie()->clear('realm');
        }
        return $this->redirect()->toUrl($callback);
    }

}