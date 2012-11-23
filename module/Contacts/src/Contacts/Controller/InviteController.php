<?php
namespace Contacts\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Eva\Api,
    Core\Auth;

class InviteController extends AbstractActionController
{
    public function indexAction()
    {
        $user = Auth::getLoginUser();
    
        if(isset($user['isSuperAdmin']) || !$user){
            exit;
        } 
        
        $callback = $this->params()->fromQuery('r');
        $service = $this->params()->fromQuery('service');
        $emails = $this->params()->fromPost('email');
        
        if (!$emails) {
            exit;
        }
        
        $config = $this->getServiceLocator()->get('config');
        $helper = $this->getEvent()->getApplication()->getServiceManager()->get('viewhelpermanager')->get('serverurl');
        $url = $helper() . '/register/';
        
        if (!isset($config['contacts']['invite_mail'])) {
            exit;
        }

        $inviteModel = Api::_()->getModel('Contacts\Model\Invite');
        $inviteModel->setUser($user);
        $inviteModel->setRegUrl($url);
        
        $params['emails']       = $emails;
        $params['subject']      = $config['contacts']['invite_mail']['subject'];
        $params['template']     = $config['contacts']['invite_mail']['template'];
        $params['templatePath'] = $config['contacts']['invite_mail']['templatePath'];
        $inviteModel->sendInvite($params);
        foreach ($emails as $email) {
            $this->removeContacts($service, $email);
        }

        return $this->redirect()->toUrl($callback);
    }

    public function removeContacts($adapter, $email)
    {
        if (!$adapter || !$email) {
            return false;
        }

        $config = $this->getServiceLocator()->get('config');
        $import = new \Contacts\ContactsImport($adapter, false, array(
            'cacheConfig' => $config['cache']['contacts_import'],
        ));
        $import->getStorage()->removeContacts($email);
    }
}
