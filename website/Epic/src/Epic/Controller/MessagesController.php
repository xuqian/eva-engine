<?php
namespace Epic\Controller;

use Eva\Api,
    Eva\Mvc\Controller\ActionController,
    Eva\View\Model\ViewModel,
    Message\Form;

class MessagesController extends ActionController
{
    public function removeAction()
    {
        $id = $this->params('id');
        $itemModel = Api::_()->getModel('Message\Model\Conversation');
        $item = $itemModel->getConversation($id)->toArray();
        
        $user = \Core\Auth::getLoginUser(); 
        if ($user['id'] != $item['author_id']) {
            exit; 
        }

        return array(
            'callback' => $this->params()->fromQuery('callback'),
            'item' => $item,
        ); 
    }

    public function indexAction()
    {
        $query = $this->getRequest()->getQuery();
        $to = $query['to'];
        $form = new Form\IndexForm();
        $form->bind($query);
        if($form->isValid()){
            $query = $form->getData();
        } else {
            return array(
                'form' => $form,
                'items' => array(),
            );
        }

        $user = \Core\Auth::getLoginUser(); 

        if ($user['id'] != $query['author_id']) {
            exit; 
        }

        $itemModel = Api::_()->getModel('Message\Model\Index');
        $items = $itemModel->setItemList($query)->getIndexList();
        $items = $items->toArray(array(
            'self' => array(
                '*',
            ),
            'join' => array(
                'User' => array(
                    'id',
                    'userName',
                    'email',
                ),
                'Conversation' => array(
                    'self' => array(
                        'message_id',
                        'sender_id',
                    ),
                    'join' => array(
                        'Message' => array(
                            '*',
                        ),
                    ),
                ),
            ),
        ));
        unset($query['author_id']);
        
        $paginator = $itemModel->getPaginator();
        
        return array(
            'items' => $items,
            'query' => $query,
            'to' => $to,
            'paginator' => $paginator,
        );
    }

    public function getAction()
    {
        $id = $this->params('id');
        $userModel = Api::_()->getModel('User\Model\User');
        $user = $userModel->getUser($id); 

        $query = $this->getRequest()->getQuery();
        $form = new Form\ConversationSearchForm();
        $form->bind($query);
        if($form->isValid()){
            $query = $form->getData();
        } else {
            return array(
                'form' => $form,
                'items' => array(),
            );
        }

        if (!$user) {
           return $this->getResponse()->setStatusCode(401);  
        }

        if (!isset($query['author_id'])) {
            $author = \Core\Auth::getLoginUser();
            $query['author_id'] = $author['id']; 
        }

        if ($user['id'] == $query['author_id']) {
            $this->redirect()->toUrl('/messages/'); 
        }

        $query['user_id'] = $user['id'];

        $itemModel = Api::_()->getModel('Message\Model\Conversation');
        $items = $itemModel->setItemList($query)->getConversationList();
        $itemModel->markAsRead($items);

        $items = $items->toArray(array(
            'self' => array(
                '*',
            ),
            'join' => array(
                'Sender' => array(
                    'id',
                    'userName',
                    'email',
                ),
                'Recipient' => array(
                    'id',
                    'userName',
                ),
                'Message' => array(
                    'body',
                ),
            ),
        ));
        $paginator = $itemModel->getPaginator();

        unset($query['author_id']);
        unset($query['user_id']);

        return array(
            'user' => $user,
            'items' => $items,
            'item' => array('Conversation' => array('recipient_id' => $user['id'])),
            'query' => $query,
            'paginator' => $paginator,
        );
    }

    public function sendAction()
    {
        return array(
            'to' => $this->params('id')
        );
    }
}
