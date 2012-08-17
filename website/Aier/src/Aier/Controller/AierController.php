<?php
namespace Aier\Controller;

use Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class AierController extends ActionController
{
    protected $addResources = array(
    );

    public function indexAction()
    {
        $categoryModel = \Eva\Api::_()->getModel('Blog\Model\Category');
        $categories = $categoryModel->getCategories();
        
        $res = array();

        if ($categories) {
            foreach ($categories as $cate) {
                $res[$cate['urlName']] = $cate;
            }
        }

        $view = new ViewModel(array(
            'categories' => $res,
        ));
        $view->setTemplate('aier/index');
        return $view;
    }
}
