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
        $request = $this->getRequest();
        $query = $request->getQuery();

        $form = new \Epic\Form\EventSearchForm();
        $form->bind($query)->isValid();
        $selectQuery = $form->getData();

        $itemModel = Api::_()->getModel('Event\Model\Event');
        if(!$selectQuery){
            $selectQuery = array(
                'page' => 1
            );
        }
        $selectQuery['eventStatus'] = 'active';
        $selectQuery['visibility']  = 'public';
        $items = $itemModel->setItemList($selectQuery)->getEventdataList();
        $items = $items->toArray(array(
            'self' => array(
            ),
        ));
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
        $calendar = new Calendar();
        $calendarArray = $calendar->toArray();
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
            ),
        ));

        if(!$item || ($item['eventStatus'] != 'finished' && $item['eventStatus'] != 'active')){
            $item = array();
            $this->getResponse()->setStatusCode(404);
        }

        $user = Auth::getLoginUser(); 
        //Public User Area
        $this->forward()->dispatch('UserController', array(
            'action' => 'user',
            'id' => $user['id'],
        ));

        list($items, $paginator) = $this->forward()->dispatch('FeedController', array(
            'action' => 'index',
            'event_id' => $item['id'],
        ));

        $view = new ViewModel(array(
            'item' => $item,
            'items' => $items,
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
