<?php
namespace Epic\Jobs;

use Eva\Api;
use Eva\Job\RelatedJobInterface;
use Core\JobManager;


class SendNoticeByActivityAt implements RelatedJobInterface
{
    public $args;

    public function perform()
    {
        $args = $this->args;

        $activityId = $args['id'];
        $userId = $args['user_id'];
        $atUserId = $args['at_user_id'];
        $notificationId = $args['notification_id'];
        $notificationKey = $args['notificationKey'];
        $activityId = $args['activity_id'];
        $messageId = $args['message_id'];

        $noticeModel = Api::_()->getModel('Notification\Model\Notice');
        
        $noticeModel->createNotice(array(
            'user_id' => $atUserId,
            'message_id' => $messageId,
            'notification_id' => $notificationId,
            'notificationKey' => $notificationKey,
            'createTime' => \Eva\Date\Date::getNow(),
            'content' => "User $userId @ you in activity $activityId",
        ));


        //TODO:Insert into messages_users table
    }
}
