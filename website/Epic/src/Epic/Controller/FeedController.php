<?php
namespace Epic\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Core\Auth,
    Eva\View\Model\ViewModel;
use Activity\Form;

class FeedController extends ActionController
{
    public function indexAction()
    {
        $userId = $this->params('user_id');
        $page = $this->params()->fromQuery('page', 1);

        $feedMap = array(
            'self' => array(
                '*',
                'getContentHtml()',
                'getVideo()',
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
        $activityList = $itemModel->getUserActivityList(array(
            'user_id' => $userId,
            'page' => $page,
        ))->getActivityList($feedMap);
        $paginator = $itemModel->getUserActivityPaginator();

        $userList = array();
        $userList = $itemModel->getUserList()->toArray();

        $forwardActivityList = $itemModel->getForwardActivityList()->getActivityList($feedMap);
        
        $activityList = $itemModel->combineList($activityList, $userList, 'User', array('user_id' => 'id'));
        $items = $itemModel->combineList($activityList, $forwardActivityList, 'ForwardActivity', array('reference_id' => 'id'));

        return array($items, $paginator);
    }

    public function getAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            return $this->deleteAction();
        }
        return $this->feedAction();
    }

    public function deleteAction()
    {
        $postData = $this->params()->fromPost();
        $callback = $this->params()->fromPost('callback');

        $form = new Form\MessageDeleteForm();
        $form->bind($postData);
        if ($form->isValid()) {

            $postData = $form->getData();
            $itemModel = Api::_()->getModel('Activity\Model\Activity');
            $itemModel->setItem($postData)->removeActivity();

            if($callback){
                $this->redirect()->toUrl($callback);
            }

        } else {
            return array(
                'post' => $postData,
            );
        }
    
    }

    public function feedAction()
    {
        $id = $this->params('id');
        $itemModel = Api::_()->getModel('Activity\Model\Activity');
        $item = $itemModel->getActivity($id, array(
            'self' => array(
                '*',
                'getVideo()',
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
                    'self' => array(
                        '*',
                    )
                ),
                'ForwardActivity' => array(
                    'self' => array(
                        '*',
                        'getVideo()',
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

        $this->forward()->dispatch('UserController', array(
            'action' => 'user',
            'id' => $item['user_id'],
        ));

        $feedMap = array(
            'self' => array(
                '*',
                'getContentHtml()',
                'getVideo()',
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
        $userList = $itemModel->getUserList()->toArray();
        $items = $itemModel->combineList($commentActivityList, $userList, 'User', array('user_id' => 'id'));

        return array(
            'item' => $item,
            'items' => $items,
        );
    }
}