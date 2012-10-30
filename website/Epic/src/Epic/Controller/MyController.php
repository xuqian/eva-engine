<?php
namespace Epic\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;
use Core\Auth;

class MyController extends ActionController
{

    public function blogAction()
    {
        $user = Auth::getLoginUser();
        $viewModel = $this->forward()->dispatch('UserController', array(
            'action' => 'blog',
            'id' => $user['userName'],
        )); 
        $viewModel->setTemplate('epic/my/blog');
        return $viewModel;
    }

    public function friendAction()
    {
        $user = Auth::getLoginUser();
        $selectQuery = array(
            'from_user_id' => $user['id'],
            'relationshiopStatus' => 'approved',
            'page' => $this->params()->fromQuery('page', 1),
        );

        $itemModel = Api::_()->getModel('User\Model\Friend');
        $items = $itemModel->setItemList($selectQuery)->getFriendList();
        $items->toArray(array(
            'self' => array(
            
            ),
            'join' => array(
                'User' => array(
                    'self' => array(
                        '*'
                    ), 
                    'join' => array(
                        'Profile' => array(
                            '*'
                        ),
                    ),
                ),
            ),
        ));

        $paginator = $itemModel->getPaginator();

        return array(
            'items' => $items,
            'query' => $selectQuery,
            'paginator' => $paginator,
        );
    }

    public function albumAction()
    {
    }

    public function groupAction()
    {
    }

    public function eventAction()
    {
    }

    public function registerAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $item = $request->getPost();
            $form = new \User\Form\RegisterForm();
            $form->bind($item);
            if ($form->isValid()) {
                $callback = $this->params()->fromPost('callback');
                $callback = $callback ? $callback : '/';

                $item = $form->getData();
                $itemModel = Api::_()->getModel('User\Model\Register');
                $itemModel->setItem($item)->register();
                $this->redirect()->toUrl($callback);
            } else {
            }
            return array(
                'form' => $form,
                'item' => $item,
            );
        }
    }
}
