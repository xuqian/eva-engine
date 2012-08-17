<?php
namespace Gwa\Controller;

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
        $form = Api::_()->getForm('Gwa\Form\ContactForm');

        if($request->isPost()){
            $postData = $request->getPost();
            $form->init();
            $form->setData($postData)->enableFilters();
            if ($form->isValid()) {
                $postData = $form->getData();

                $mail = new \Core\Mail();
                $mail->getMessage()
                ->setSubject("甘肃婚庆行业协会有一条新留言")
                ->setData($postData)
                ->setTemplatePath(EVA_ROOT_PATH . '/website/Gwa/view/')
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
