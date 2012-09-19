<?php
namespace Epic\Controller;

use Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class LoginController extends ActionController
{
    protected $addResources = array(
    );

    public function indexAction()
    {
        $res = array();
        $this->layout('layout/login');

        $view = new ViewModel();
        
        $view->setTemplate('epic/login/index');
        return $view;
    }
}
