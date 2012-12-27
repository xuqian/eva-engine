<?php
namespace Epic\Controller;

use Epic\Form,
    Eva\Api,
    Eva\Mvc\Controller\RestfulModuleController,
    Eva\View\Model\ViewModel,
    Zend\View\Model\JsonModel;

class DataController extends RestfulModuleController
{
    protected $renders = array(
        'restIndexGroup' => 'blank',    
    );

    public function blogAction()
    {
        $this->changeViewModel('json');
        $query = $this->getRequest()->getQuery();
        $form = new \Blog\Form\PostSearchForm();
        $form->bind($query);
        if($form->isValid()){
            $query = $form->getData();
        } else {
            return new JsonModel(array(
                'form' => $form,
                'items' => array(),
            ));
        }
        $groupId = $this->params()->fromQuery('group_id');
        $inGroup = $this->params()->fromQuery('inGroup');

        if ($groupId || $inGroup) { 
            $query['inGroup'] = true;
            $query['group_id'] = $groupId;
            
            $itemModel = Api::_()->getModel('Group\Model\Post'); 
            $items = $itemModel->setItemList($query)->getPostList(array(
                'self' => array(
                    '*', 
                ),
                'join' => array(
                    'Group' => array(
                        '*'
                    ),
                    'Text' => array(
                        'self' => array(
                            '*',
                            'getPreview()',
                        )
                    ),
                ),
            ));
        } else {
            $itemModel = Api::_()->getModel('Blog\Model\Post');
            $items = $itemModel->setItemList($query)->getPostList(array(
                'join' => array(
                    'Text' => array(
                        'self' => array(
                            '*',
                            'getPreview()',
                        )
                    ),
                )
            ));
        }

        if (count($items) > 0) {
            foreach ($items as $key=>$item) {
                if (isset($item['Group']) && count($item['Group']) > 0) {
                    unset($items[$key]['File'][0]);
                    $items[$key]['Group'] = $item['Group'][0];
                } else {
                    unset($items[$key]['Group']);
                }
            }
        }

        $paginator = $itemModel->getPaginator();
        $paginator = $paginator ? $paginator->toArray() : null;

        if(Api::_()->isModuleLoaded('User')){
            $userList = array();
            $userList = $itemModel->getUserList(array(
                'columns' => array(
                    'id',
                    'userName',
                    'email',
                ),
            ))->toArray(array(
                'self' => array(
                    'getEmailHash()',
                ),
            ));
            $items = $itemModel->combineList($items, $userList, 'User', array('user_id' => 'id'));
        }

        return new JsonModel(array(
            'items' => $items,
            'paginator' => $paginator,
        ));
    }

    public function isfriendAction()
    {
        $this->changeViewModel('json');

        $user = \Core\Auth::getLoginUser();
        if(!$user) {
            return new JsonModel(array(
                'item' => null
            ));
        }
        $selectQuery = array(
            'from_user_id' => $this->params()->fromQuery('user_id'),
            'to_user_id' => $user['id'],
        );
        $itemModel = Api::_()->getModel('User\Model\Friend');
        $item = $itemModel->setItemList($selectQuery)->getFriendList()->toArray();
        return new JsonModel(array(
            'item' => $item,
        ));
    }

    public function friendAction()
    {
        $this->changeViewModel('json');
        $selectQuery = array(
            'from_user_id' => $this->params()->fromQuery('user_id'),
            'relationshiopStatus' => 'approved',
            'page' => $this->params()->fromQuery('page', 1),
            'rows' => $this->params()->fromQuery('rows', 16),
        );
        $itemModel = Api::_()->getModel('User\Model\Friend');
        $items = $itemModel->setItemList($selectQuery)->getFriendList()->toArray(array(
            'self' => array(
            ),
            'join' => array(
                'User' => array(
                    'self' => array(
                        'id',
                        'userName',
                        'email',
                        'getEmailHash()',
                    ), 
                    'join' => array(
                        'Profile' => array(
                            '*'
                        ),
                    ),
                ),
            ),
        ));

        $paginator = $itemModel->getPaginator();
        $paginator = $paginator ? $paginator->toArray() : null;

        return new JsonModel(array(
            'items' => $items,
            'paginator' => $paginator,
        ));
    }

    public function eventAction()
    {
        $this->changeViewModel('json');
        $query = $this->getRequest()->getQuery();
        $form = new \Epic\Form\EventSearchForm();
        $form->bind($query);
        if($form->isValid()){
            $query = $form->getData();
        } else {
            return array(
                'form' => $form,
                'items' => array(),
            );
        }
        
        $groupId = $this->params()->fromQuery('group_id');
        $inGroup = $this->params()->fromQuery('inGroup');

        if ($groupId || $inGroup) { 
            $itemModel = Api::_()->getModel('Group\Model\Event'); 
            $query['inGroup'] = true;
            $query['group_id'] = $groupId;
            
            $items = $itemModel->setItemList($query)->getEventdataList(array(
                'self' => array(
                    '*'
                ),
                'join' => array(
                    'Count' => array(
                        '*',
                    ),
                    'File' => array(
                        'self' => array(
                            '*',
                            'getThumb()',
                        )
                    ),
                    'Group' => array(
                        '*'
                    ),
                ), 
            ));

        } else {
            $itemModel = Api::_()->getModel('Event\Model\Event');
            $items = $itemModel->setItemList($query)->getEventdataList();
            $items = $items->toArray(array(
                'self' => array(
                    '*'
                ),
                'join' => array(
                    'Count' => array(
                        '*',
                    ),
                    'File' => array(
                        'self' => array(
                            '*',
                            'getThumb()',
                        )
                    ),
                ), 
            ));
        }

        if (count($items) > 0) {
            foreach ($items as $key=>$item) {
                if (isset($item['File']) && count($item['File']) > 0) {
                    unset($items[$key]['File'][0]);
                    $items[$key]['File'] = $item['File'][0];
                } else {
                    unset($items[$key]['File']);
                }

                if (isset($item['Group']) && count($item['Group']) > 0) {
                    unset($items[$key]['File'][0]);
                    $items[$key]['Group'] = $item['Group'][0];
                } else {
                    unset($items[$key]['Group']);
                }
            }
        }

        $paginator = $itemModel->getPaginator();
        $paginator = $paginator ? $paginator->toArray() : null;

        if(Api::_()->isModuleLoaded('User')){
            $userList = array();
            $userList = $itemModel->getUserList(array(
                'columns' => array(
                    'id',
                    'userName',
                    'email',
                ),
            ))->toArray(array(
                'self' => array(
                    'getEmailHash()',
                ),
            ));
            $items = $itemModel->combineList($items, $userList, 'User', array('user_id' => 'id'));
        }

        return new JsonModel(array(
            'items' => $items,
            'paginator' => $paginator,
        ));
    }

    public function groupAction()
    {
        $this->changeViewModel('json');
        $query = $this->getRequest()->getQuery();
        $form = new \Epic\Form\GroupSearchForm();
        $form->bind($query);
        if($form->isValid()){
            $query = $form->getData();
        } else {
            return array(
                'form' => $form,
                'items' => array(),
            );
        }

        $itemModel = Api::_()->getModel('Group\Model\Group');
        $items = $itemModel->setItemList($query)->getGroupList();
        $items = $items->toArray(array(
            'self' => array(
            ),
            'join' => array(
                'Count' => array(
                    '*',
                ),
                'File' => array(
                    'self' => array(
                        '*',
                        'getThumb()',
                    )
                ),
            ), 
        ));
        
        if (count($items) > 0) {
            foreach ($items as $key=>$item) {
                if (count($item['File']) > 0) {
                    unset($items[$key]['File'][0]);
                    $items[$key]['File'] = $item['File'][0];
                } else {
                    unset($items[$key]['File']);
                }
            }
        }

        $paginator = $itemModel->getPaginator();
        $paginator = $paginator ? $paginator->toArray() : null;

        if(Api::_()->isModuleLoaded('User')){
            $userList = array();
            $userList = $itemModel->getUserList(array(
                'columns' => array(
                    'id',
                    'userName',
                    'email',
                ),
            ))->toArray(array(
                'self' => array(
                    'getEmailHash()',
                ),
            ));
            $items = $itemModel->combineList($items, $userList, 'User', array('user_id' => 'id'));
        }

        return new JsonModel(array(
            'items' => $items,
            'paginator' => $paginator,
        ));
    }
}
