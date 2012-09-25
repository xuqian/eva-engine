<?php
namespace Epic\Controller;

use Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class CityController extends ActionController
{
    protected $addResources = array(
    );

    public function indexAction()
    {
        $city = $this->params()->fromQuery('city');
        if($city) {
            $this->cookie()->crypt(true)->write('city', $city);
            return $this->redirect()->toUrl('/login/');
        }
        $this->layout('layout/empty');
        $view = new ViewModel();
        $view->setTemplate('epic/city/index');
        return $view;
    }
}
