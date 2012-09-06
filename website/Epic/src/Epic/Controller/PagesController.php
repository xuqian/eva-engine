<?php
namespace Epic\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class PagesController extends ActionController
{
    protected $addResources = array(
    );

    public function getAction()
    {
        $id = $this->params('id');
        $this->layout('layout/empty');
        $postModel = Api::_()->getModel('Blog\Model\Post');
        $postinfo = $postModel->setItemParams($id)->getPost();
        $view = new ViewModel(array(
            'post' => $postinfo,
        ));
        $view->setTemplate('epic/pages/get');
        return $view;
    }
}
