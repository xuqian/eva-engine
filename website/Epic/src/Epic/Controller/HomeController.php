<?php
namespace Epic\Controller;

use Zend\View\Model\ViewModel;
use Eva\Mvc\Controller\ActionController;
use Activity\Form;
use Zend\Mvc\MvcEvent;
use Eva\Api;

class HomeController extends ActionController
{

    public function indexAction()
    {
        $query = array(
            'page' => $this->params()->fromQuery('page', 1),
        );

        $user = \Core\Auth::getLoginUser();
        if(!$user){
            return $this->getResponse()->setStatusCode(401);
        }

        //Public User Area
        $this->forward()->dispatch('UserController', array(
            'action' => 'user',
            'id' => $user['id'],
        ));


        list($items, $paginator) = $this->forward()->dispatch('FeedController', array(
            'action' => 'index',
            'user_id' => $user['id'],
        ));

        $this->getServiceLocator()->get('Application')->getEventManager()->attach(MvcEvent::EVENT_RENDER, function($event) {
            $viewModel = $event->getViewModel();
            $viewModel->setVariables(array(
                'viewAsGuest' => 0
            ));
            $viewModelChildren = $viewModel->getChildren();
            foreach($viewModelChildren as $childViewModel){
                $childViewModel->setVariables(array(
                    'viewAsGuest' => 0
                ));
            }
        }, -100);

        return array(
            'user' => $user,
            'items' => $items,
            'query' => $query,
            'paginator' => $paginator,
        );
    }
}
