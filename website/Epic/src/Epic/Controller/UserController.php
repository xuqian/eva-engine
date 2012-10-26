<?php
namespace Epic\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class UserController extends ActionController
{

    public function indexAction()
    {
    }

    public function getAction()
    {
        $viewModel = $this->forward()->dispatch('HomeController', array(
            'action' => 'index',
        )); 
        $viewModel->setVariables(array(
            'viewAsGuest' => 1
        ));
        return $viewModel;
    }

    public function blogAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $query = array(
            'page' => $page,
        );

        $user = \Core\Auth::getLoginUser();
        $itemListQuery = array_merge(array(
            'user_id' => $user['id'],
            'order' => 'iddesc',
        ), $query);
        $itemModel = Api::_()->getModel('Blog\Model\Post');
        $items = $itemModel->setItemList($itemListQuery)->getPostList(array(
            'self' => array(
                '*',
            ),
            'join' => array(
                'Text' => array(
                    'self' => array(
                        '*',
                        'getContentHtml()',
                    ),
                ),
            ),
            'proxy' => array(
                'File\Item\File::PostCover' => array(
                    'self' => array(
                        '*',
                        'getThumb()',
                    ),
                )
            ),
        ));
        $userList = $itemModel->getUserList()->toArray();
        $items = $itemModel->combineList($items, $userList, 'User', array('user_id' => 'id'));

        $paginator = $itemModel->getPaginator();
        return array(
            'items' => $items,
            'query' => $query,
            'paginator' => $paginator,
        );
    }

    public function friendAction()
    {
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
