<?php
namespace Group\Admin\Controller;

use Group\Form,
    Eva\Api,
    Eva\Mvc\Controller\RestfulModuleController,
    Eva\View\Model\ViewModel,
    Core\Admin\MultiForm,
    Core\Controller\Exception;

class CategorymultiController extends RestfulModuleController
{
    protected $addResources = array(
        'reorder',
    );

    protected $renders = array(
        'restPostCategorymultiReorder' => 'blank',
    );

    public function restPostCategorymultiReorder()
    {
        $request = $this->getRequest();
        $postData = $request->getPost();
        $dataArray = MultiForm::getPostDataArray($postData);

        $categoryTable = Api::_()->getDbTable('Group\DbTable\Categories');

        foreach($dataArray as $key => $array){
            $categoryTable->where(array('id' => $array['id']))->save(array(
                'orderNumber' => $array['order']
            ));
        }
        $this->redirect()->toUrl('/admin/group/category/');
    }
}
