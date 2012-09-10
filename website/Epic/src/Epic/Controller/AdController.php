<?php
namespace Epic\Controller;

use Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class AdController extends ActionController
{
    protected $addResources = array(
    );

    public function indexAction()
    {
        $res = array();
        $this->layout('layout/empty');

        $view = new ViewModel();
        
        $view->setTemplate('epic/ad/index');
        return $view;
    }
}
