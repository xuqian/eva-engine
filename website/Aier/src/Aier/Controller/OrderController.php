<?php
namespace Aier\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;

class OrderController extends ActionController
{
    protected $addResources = array(
    );

    public function indexAction()
    {
        $request = $this->getRequest();
        $form = Api::_()->getForm('Aier\Form\ContactForm');

        if($request->isPost()){
            $postData = $request->getPost();
            $form->init();
            $form->setData($postData)->enableFilters();
            if ($form->isValid()) {
                $postData = $form->getData();

                $mail = new \Core\Mail();
                $mail->getMessage()
                ->setSubject("网站有一条新留言")
                ->setData($postData)
                ->setTemplatePath(EVA_ROOT_PATH . '/website/Aier/view/')
                ->setTemplate('mail/leavemessage');
                $mail->send();
                $this->flashMessenger()->addMessage('message-sent');
                return $this->redirect()->toUrl('/order/');

            } else {
                //p($form->getInputFilter()->getInvalidInput());
            }
        } else {

        }


        $view = new ViewModel(array(
        ));
        $view->setTemplate('gwa/order/index');
        $view->setVariables(array(
            'flashMessenger' => $this->flashMessenger(),
            'form' => $form,
        ));
        return $view;
    }
}
