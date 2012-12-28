<?php
namespace Epic\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel;
use Core\Auth;
use Epic\Form;
use Eva\Date\Calendar;

class EventController extends ActionController
{
    public function indexAction()
    {
        return $this->listAction();
    }

    public function listAction()
    {
        $request = $this->getRequest();
        $query = $request->getQuery();

        $form = new \Epic\Form\EventSearchForm();
        $form->bind($query)->isValid();
        $selectQuery = $form->getData();

        if(!$selectQuery){
            $selectQuery = array(
                'page' => 1
            );
        }
        $selectQuery['eventStatus'] = 'active';
        $selectQuery['visibility']  = 'public';
        if($selectQuery['city'] == 'mycity'){
            $selectQuery['city'] = $this->cookie()->crypt(false)->read('city');
        }
        
        $selectMap = array(
            'self' => array(
            ),
            'join' => array(
                'Text' => array(
                    'self' => array(
                        '*',
                    ),
                ),
                'File' => array(
                    'self' => array(
                        '*',
                        'getThumb()',
                    )
                ),
                'Category' => array(
                    '*'
                ),
                'Count' => array(
                    '*'
                ),
            ),
        );
        
        $groupId = $this->params('group_id');
        $inGroup = $this->params('inGroup');
        $order = $this->params('order');
        
        if ($groupId || $inGroup) { 
            $itemModel = Api::_()->getModel('Group\Model\Event'); 
            $selectQuery['inGroup'] = true;
            $selectQuery['group_id'] = $groupId;
            $selectQuery['order'] = $order;
            $selectMap['join']['Group'] = array('*');
        } else {
            $itemModel = Api::_()->getModel('Event\Model\Event');
        }    
        
        $items = $itemModel->setItemList($selectQuery)->getEventdataList();
        $items = $items->toArray($selectMap);
        $paginator = $itemModel->getPaginator();

        $user = Auth::getLoginUser();
        $joinList = array();
        if($user) {
            $joinModel = Api::_()->getModel('Event\Model\EventUser');
            $joinList = $joinModel->setItemList(array(
                'user_id' => $user['id']
            ))->getEventUserList()->toArray();
        }

        //Public User Area
        $this->forward()->dispatch('UserController', array(
            'action' => 'user',
            'id' => $user['id'],
        ));

        $items = $itemModel->combineList($items, $joinList, 'Join', array('id' => 'event_id'));

        $startDay = $this->params()->fromQuery('start');
        $calendarModel = Api::_()->getModel('Event\Model\Calendar');
        $calendarArray = $calendarModel->getEventCalendar(array(
            'startDay' => $startDay,
        ));
        $today = $calendarArray['today']['datedb'];
        $week = array();
        foreach($calendarArray['days'] as $weekArray){
            if($week){
                break;
            }
            foreach($weekArray as $day){
                if($day['datedb'] == $today){
                    $week = $weekArray;
                    break;
                }
            }
        }

        return array(
            'calendar' => $calendarArray,
            'week' => $week,
            'form' => $form,
            'items' => $items,
            'query' => $query,
            'paginator' => $paginator,
        );      
    }

    public function getAction()
    {
        $id = $this->params('id');
        
        $itemModel = Api::_()->getModel('Event\Model\Event'); 
        $item = $itemModel->getEventdata($id, array(
            'self' => array(
                '*',
            ),
            'join' => array(
                'Text' => array(
                    'self' => array(
                        '*',
                    ),
                ),
                'File' => array(
                    'self' => array(
                        '*',
                        'getThumb()',
                    )
                ),
                'Category' => array(
                    '*'
                ),
                'Count' => array(
                    '*'
                ),
            ),
        ));

        if(!$item || $item['eventStatus'] != 'active'){
            $item = array();
            $this->getResponse()->setStatusCode(404);
        }

        $user = Auth::getLoginUser(); 
        //Public User Area
        $this->forward()->dispatch('UserController', array(
            'action' => 'user',
            'id' => $user['id'],
        ));

        if($user) {
            $joinModel = Api::_()->getModel('Event\Model\EventUser');
            $joinList = $joinModel->setItemList(array(
                'user_id' => $user['id'],
                'event_id' => $item['id'],
            ))->getEventUserList()->toArray();

            if (count($joinList) > 0) {
                $item['Join'] = $joinList[0];
            }
        } 

        list($items, $paginator) = $this->forward()->dispatch('FeedController', array(
            'action' => 'index',
            'event_id' => $item['id'],
        ));

        $memberModel = Api::_()->getModel('Event\Model\EventUser'); 
        $members = $memberModel->setItemList(array('event_id' => $item['id'], 'noLimit' => true))->getEventUserList();
        $members = $members->toArray(
            array(
                'self' => array(
                    '*',
                ),
                'join' => array(
                    'User' => array(
                        '*',
                    ),
                ),
            )
        );

        $view = new ViewModel(array(
            'item' => $item,
            'items' => $items,
            'members' => $members,
            'paginator' => $paginator,
        ));
        return $view; 
    }
    
    public function removeAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {

            $postData = $this->params()->fromPost();
            $callback = $this->params()->fromPost('callback');

            $form = new \Event\Form\EventDeleteForm();
            $form->bind($postData);
            if ($form->isValid()) {

                $postData = $form->getData();
                $itemModel = Api::_()->getModel('Event\Model\Event');
                $itemModel->setItem($postData)->removeEventdata();
                $callback = $callback ? $callback : '/my/event/';
                $this->redirect()->toUrl($callback);

            } else {
                return array(
                    'post' => $postData,
                );
            }

        } else {
            $id = $this->params('id');
            $itemModel = Api::_()->getModel('Event\Model\Event');
            $item = $itemModel->getEventdata($id)->toArray();

            $user = Auth::getLoginUser(); 
            //Public User Area
            $this->forward()->dispatch('UserController', array(
                'action' => 'user',
                'id' => $user['id'],
            ));

            return array(
                'callback' => $this->params()->fromQuery('callback'),
                'item' => $item,
            );

        }

    }

    public function createAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return array(
                'params' => $request->getQuery()
            );
        }

        $postData = $request->getPost();
        $callback = $this->params()->fromPost('callback');
        $form = new Form\EventCreateForm();
        $form->useSubFormGroup()
            ->bind($postData);

        if ($form->isValid()) {
            $postData = $form->getData();
            $itemModel = Api::_()->getModel('Event\Model\Event');
            $eventId = $itemModel->setItem($postData)->createEventdata();
            $callback = $callback ? $callback : '/events/edit/' . $eventId;
            $this->redirect()->toUrl($callback);
        } else {
            $user = Auth::getLoginUser(); 
            //Public User Area
            $this->forward()->dispatch('UserController', array(
                'action' => 'user',
                'id' => $user['id'],
            ));
        }

        return array(
            'form' => $form,
            'post' => $postData,
        );
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $viewModel = new ViewModel();
        $viewModel->setTemplate('epic/event/create');
        if ($request->isPost()) {
            $postData = $request->getPost();
            $callback = $this->params()->fromPost('callback');
            $form = new Form\EventEditForm();
            $form->useSubFormGroup()
                ->bind($postData);

            if ($form->isValid()) {
                $postData = $form->getData();
                $itemModel = Api::_()->getModel('Event\Model\Event');
                $eventId = $itemModel->setItem($postData)->saveEventdata();
                $callback = $callback ? $callback : '/events/edit/' . $eventId;
                $this->redirect()->toUrl($callback);

            } else {
            }

            $viewModel->setVariables(array(
                'form' => $form,
                'item' => $postData,
            ));
        } else {
            $id = $this->params('id');
            $itemModel = Api::_()->getModel('Event\Model\Event');
            $item = $itemModel->getEventdata($id, array(
                'self' => array(
                    '*',
                ),
                'join' => array(
                    'Text' => array(
                        'self' => array(
                            '*',
                        ),
                    ),
                    'File' => array(
                        'self' => array(
                            '*',
                            'getThumb()',
                        )
                    ),
                    'Category' => array(
                        '*'
                    ),
                ),
            ));
            if(isset($item['EventFile'][0])){
                $item['EventFile'] = $item['EventFile'][0];
            }

            $user = Auth::getLoginUser(); 
            //Public User Area
            $this->forward()->dispatch('UserController', array(
                'action' => 'user',
                'id' => $user['id'],
            ));

            $viewModel->setVariables(array(
                'item' => $item,
            ));
        }

        return $viewModel;
    }
}
