<?php
namespace Aier\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class CategoryController extends ActionController
{
    protected $addResources = array(
    );

    public function getAction()
    {
        $request = $this->getRequest();
        $query = $request->getQuery();
        
        $query['category'] = $this->getEvent()->getRouteMatch()->getParam('id');
        
        $categoryModel = Api::_()->getModel('Blog\Model\Category');
        $categoryinfo = $categoryModel->setItemParams($query['category'])->getCategory();

        $postModel = Api::_()->getModel('Blog\Model\Post');
        $posts = $postModel->setItemListParams((array) $query)->getPosts();
        $paginator = $postModel->getPaginator();

        $view = new ViewModel(array(
            'category' => $categoryinfo,
            'posts' => $posts,
            'query' => $query,
            'paginator' => $paginator,
        ));
        $view->setTemplate('aier/category/get');
        return $view;
    }
}
