<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Mvc
 */

namespace Epic\Event;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Core\JobManager;

/**
 * @category   Zend
 * @package    Zend_Mvc
 */
class Listener implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * Attach to an event manager
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('activity.model.activity.create.post', array($this, 'notificateAtUsers'));
    }

    /**
     * Detach all our listeners from the event manager
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function notificateAtUsers($e)
    {
        $activityModel = $e->getTarget();
        $item = $activityModel->getItem();
        $activityId = $item->id;
        $userId = $item->user_id;
        $userNames = $item->getParser()->getUserNames();
        if(!$userNames){
            return false;
        }

        $userModel = \Eva\Api::_()->getModel('User\Model\User');
        $author = $userModel->getUser($userId);

        JobManager::setQueue('notificate');
        JobManager::jobHandler('Epic\Jobs\NotificateAtUsers', array(
            'id' => $activityId,
            'user_id' => $userId,
            'authorName' => $author['userName'],
            'userNames' => $userNames,
        ));
    }
}
