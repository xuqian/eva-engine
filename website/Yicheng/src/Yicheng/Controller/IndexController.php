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
}
