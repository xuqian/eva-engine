<?php
namespace Epic\Controller;

use Zend\View\Model\ViewModel;
use Eva\Mvc\Controller\ActionController;
use Activity\Form;
use Eva\Api;

class HomeController extends ActionController
{

    public function indexAction()
    {
        $query = array(
            'order' => 'iddesc'
        );

        $user = \Core\Auth::getLoginUser();
        if(!$user){
            return $this->getResponse()->setStatusCode(401);
        }

        $itemModel = Api::_()->getModel('User\Model\User');
        $item = $itemModel->getUser($user['id']);
        $user = $item->toArray(array(
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
                'FriendsCount' => array(
                ),
            ),
        ));

        $feedMap = array(
            'self' => array(
                '*',
                'getContentHtml()',
            ),
            'join' => array(
                'File' => array(
                    'self' => array(
                        '*',
                        'getThumb()',
                    )
                ),
            ),
        );

        $itemModel = Api::_()->getModel('Activity\Model\Activity');
        $activityList = $itemModel->getUserActivityList($user['id'])->getActivityList($feedMap);

        $userList = array();
        $userList = $itemModel->getUserList()->toArray();

        $forwardActivityList = $itemModel->getForwardActivityList()->getActivityList($feedMap);
        
        $activityList = $itemModel->combineList($activityList, $userList, 'User', array('user_id' => 'id'));
        $items = $itemModel->combineList($activityList, $forwardActivityList, 'ForwardActivity', array('reference_id' => 'id'));


        return array(
            'user' => $user,
            'items' => $items,
            'query' => $query,
        );
    }
}
