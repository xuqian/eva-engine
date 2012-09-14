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
        $this->layout('layout/coming');

        $view = new ViewModel(array(
            'reg' => $this->params()->fromQuery('reg')
        ));
        $view->setTemplate('epic/index');
        return $view;
    }

    public function getAction()
    {
        $res = array();
        $this->layout('layout/empty');
        $id = $this->params('id');
        $view = new ViewModel(array(
            'id' => $id
        ));
        $view->setTemplate('epic/reg/' . $id);
        return $view;
    }
}
