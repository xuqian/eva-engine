<?php
namespace Yicheng\Controller;

use Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class IndexController extends ActionController
{
    public function indexAction()
    {
        $this->layout('layout/welcome');
        $view = new ViewModel();
        return $view;
    }


    public function homeAction()
    {
        $this->layout('layout/index');
        $view = new ViewModel();
        return $view;
    }

    public function getAction()
    {
        $this->layout('layout/index');
        $view = new ViewModel();
        $view->setTemplate('yicheng/index/' . $this->params('id'));
        return $view;
    }
}
