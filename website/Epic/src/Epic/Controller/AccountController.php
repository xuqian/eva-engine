<?php
namespace Epic\Controller;

use Eva\Api;
use Eva\Mvc\Controller\ActionController;
use Eva\View\Model\ViewModel;
use Core\Auth;
use Epic\Form;

class AccountController extends ActionController
{

    public function profileAction()
    {
        $request = $this->getRequest();
        $form = array();

        if ($request->isPost()) {
            $item = $request->getPost();
            $form = new Form\AccountEditForm();
            $form->useSubFormGroup();
            $form->bind($item);
            if ($form->isValid()) {
                $callback = $this->params()->fromPost('callback');
                $callback = $callback ? $callback : '/';

                $item = $form->getData();
                $itemModel = Api::_()->getModel('Epic\Model\User');
                $itemModel->setItem($item)->saveUser();
                $this->redirect()->toUrl($callback);
            } else {
                $item = $form->getData();
            }
        } else {
            $user = Auth::getLoginUser();
            $itemModel = Api::_()->getModel('User\Model\User');
            $item = $itemModel->getUser($user['id']);

            $item = $item->toArray(array(
                'self' => array(
                    '*',
                ),
                'join' => array(
                    'Profile' => array(
                        '*'
                    ),
                    'Roles' => array(
                        '*'
                    ),
                ),
            ));
        }
        return array(
            'item' => $item,
            'form' => $form,
        );
    }

    public function settingAction()
    {
        $request = $this->getRequest();
        $form = array();

        $user = Auth::getLoginUser();
        $itemModel = Api::_()->getModel('User\Model\User');
        $item = $itemModel->getUser($user['id']);

        $item = $item->toArray(array(
            'self' => array(
                '*',
            ),
            'join' => array(
                'Profile' => array(
                    '*'
                ),
                'Roles' => array(
                    '*'
                ),
            ),
        ));
        return array(
            'item' => $item,
            'form' => $form,
        );
    }

    public function membershipAction()
    {

    }

    public function changeemailAction()
    {
        $request = $this->getRequest();
        $postData = $request->getPost();

        $form = new \User\Form\ChangeEmailForm();
        $form->bind($postData);

        if ($form->isValid()) {
            $postData = $form->getData();
            $itemModel = Api::_()->getModel('User\Model\Account');

            $itemId = $itemModel->setItem($postData)->changeEmail();
            $this->redirect()->toUrl('/account/setting/');
        } else {
            //p($form->getMessages());
        }


        $viewModel = new ViewModel();
        $viewModel->setTemplate('epic/account/setting');
        $viewModel->setVariables(array(
            'emailForm' => $form
        ));
        return $viewModel;
    }

    public function changepasswordAction()
    {
        $request = $this->getRequest();
        $postData = $request->getPost();

        $form = new \User\Form\ChangePasswordForm();
        $form->bind($postData);

        if ($form->isValid()) {
            $postData = $form->getData();
            $itemModel = Api::_()->getModel('User\Model\Account');

            $itemId = $itemModel->setItem($postData)->changePassword();
            $this->redirect()->toUrl('/account/setting/');
        } else {
            //p($form->getMessages());
        }


        $viewModel = new ViewModel();
        $viewModel->setTemplate('epic/account/setting');
        $viewModel->setVariables(array(
            'pwForm' => $form
        ));
        return $viewModel;
    }

    public function importAction()
    {
        $user = Auth::getLoginUser();
        $itemModel = Api::_()->getModel('User\Model\Invite');
        $code = $itemModel->setUser($user)->getUserInviteHash();
        return array(
            'inviteCode' => $code
        );
    
    }

    public function addfriendAction()
    {
        $adapter = $this->params()->fromQuery('service');
        
        $user = Auth::getLoginUser();
    
        if(!$adapter){
            throw new \Contacts\Exception\InvalidArgumentException(sprintf(
                'No contacts service key found'
            ));
        }
        
        $config = $this->getServiceLocator()->get('config');
        $import = new \Contacts\ContactsImport($adapter, false, array(
            'cacheConfig' => $config['cache']['contacts_import'],
        ));
        $contacts = $import->getStorage()->loadContacts();
        
        $itemModel = \Eva\Api::_()->getModel('Contacts\Model\Contacts');
        $itemModel->setUser($user);
        $itemModel->setService($adapter);
        $contacts = $itemModel->getUserContactsInfo($contacts);
        return array(
            'contacts' => $contacts,
            'service'  => $adapter,
        );
    }

    public function inviteAction()
    {
        return $this->addfriendAction();
    }
}
