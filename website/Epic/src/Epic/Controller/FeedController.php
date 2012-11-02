<?php
namespace Epic\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Core\Auth,
    Eva\View\Model\ViewModel;

class FeedController extends ActionController
{

    public function indexAction()
    {
    }

    public function getAction()
    {
        $id = $this->params('id');
        $itemModel = Api::_()->getModel('Activity\Model\Activity');
        $item = $itemModel->getActivity($id, array(
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
                'User' => array(
                    'self' => '*'
                ),
                'ForwardActivity' => array(
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
        $commentActivityList = $itemModel->getCommentActivityList()->getActivityList($feedMap);

        $userModel = Api::_()->getModel('User\Model\User');
        $userItem = $userModel->getUser($item['user_id'])->toArray();
        $item['User'] = $userItem;

        $userList = $itemModel->getUserList()->toArray();
        $items = $itemModel->combineList($commentActivityList, $userList, 'User', array('user_id' => 'id'));


        $itemModel = Api::_()->getModel('User\Model\User');
        $user = $itemModel->getUser($item['user_id']);
        $user = $user->toArray(array(
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

        return array(
            'user' => $user,
            'item' => $item,
            'items' => $items,
        );
    }
}
