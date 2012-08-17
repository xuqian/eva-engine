<?php
namespace Aier\Api\Controller;

use File\Form,
    Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Zend\View\Model\JsonModel;

class FrontendController extends ActionController
{
    
    public function postlistAction($params = null)
    {
        $params['category'];

        if (!$params['category']) {
            return false;
        }

        if (!isset($params['page'])) {
            $params['page'] = false;
        }
        
        $postModel = Api::_()->getModel('Blog\Model\Post');
        $posts = $postModel->setItemListParams($params)->getPosts();
        
        return $posts;
    }

    public function categoryAction($params = null)
    {
        $params['category'];

        if (!$params['category']) {
            return false;
        }
        
        $categoryModel = Api::_()->getModel('Blog\Model\Category');
        $categoryinfo = $categoryModel->setItemParams($params['category'])->getCategory();
        
        return $categoryinfo;
    }
}
