<?php
namespace Oauth\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Oauth\OauthService,
    Oauth\Exception;

class AccessController extends AbstractActionController
{
    public function indexAction()
    {
        $adapter = $this->params()->fromQuery('service');
        $callback = $this->params()->fromQuery('callback');
        $version = (int) $this->params()->fromQuery('version');

        if(!$adapter){
            throw new Exception\InvalidArgumentException(sprintf(
                'No oauth service key found'
            ));
        }

        if(!$callback){
            throw new Exception\InvalidArgumentException(sprintf(
                'No oauth callback found'
            ));
        }

        $config = $this->getServiceLocator()->get('config');
        $helper = $this->getEvent()->getApplication()->getServiceManager()->get('viewhelpermanager')->get('serverurl');
        $url = $helper() . $config['oauth']['access_url_path'] . '?' . http_build_query(array(
            'callback' => urlencode($callback),
            'service' => $adapter,
            'version' => $version
        ));

        $version = $version ? 'Oauth' . $version : OauthService::VERSION_OAUTH2;
        $options = array(
            'adapter' => $adapter,
            'storage' => 'Session',
            'version' => $version,
            'callback' => $url,
        );
        $oauth = OauthService::factory($options, $this->getServiceLocator());

        $query = $this->params()->fromQuery();
        $requestToken = $oauth->getStorage()->getRequestToken();
        $accessToken = $oauth->getAdapter()->getAccessToken($query, $requestToken);
        
        //$request = $oauth->getAdapter()->getRequest();
        //$response = $oauth->getAdapter()->getResponse();

        $accessTokenArray = $oauth->getAdapter()->accessTokenToArray($accessToken);
        $oauth->getStorage()->saveAccessToken($accessTokenArray);
        return $this->redirect()->toUrl($callback);
        $view = new ViewModel();
        $view = new \Zend\View\Model\JsonModel();
        $view->setTemplate('blank');
        return $view;
    }
}
