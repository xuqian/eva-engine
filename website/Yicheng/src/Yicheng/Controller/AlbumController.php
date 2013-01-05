<?php
namespace Yicheng\Controller;

use Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class AlbumController extends ActionController
{
    public function getAction()
    {
        $this->layout('layout/index');
        $view = new ViewModel();
        return $view;
    }
}
