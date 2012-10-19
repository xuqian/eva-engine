<?php
namespace Epic\Controller;

use Zend\View\Model\ViewModel;
use Eva\Mvc\Controller\RestfulModuleController;
use Activity\Form;
use Eva\Api;

class FeedController extends RestfulModuleController
{

    public function indexAction()
    {
        $postData = $this->params()->fromPost();
        $form = new Form\MessageCreateForm();
        $form->useSubFormGroup()
             ->bind($postData);
        if ($form->isValid()) {
            $postData = $form->getData();
            $itemModel = Api::_()->getModel('Activity\Model\Activity');
            $postId = $itemModel->setItem($postData)->createActivity();
            $this->redirect()->toUrl('/user/');

        } else {
            
        }
        return array(
            'form' => $form,
            'post' => $postData,
        );
    }
}
