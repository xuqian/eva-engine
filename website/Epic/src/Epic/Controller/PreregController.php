<?php
namespace Epic\Controller;

use Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class PreregController extends ActionController
{
    protected $addResources = array(
    );

    public function indexAction()
    {
        $res = array();

        $view = new ViewModel(array(
        ));
        $view->setTemplate('epic/index');
        return $view;
    }
}
