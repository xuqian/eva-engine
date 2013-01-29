<?php
namespace Epic\Jobs;

use Eva\Api;
use Eva\Job\RelatedJobInterface;
use Core\JobManager;


class SendEmailByActivityAt implements RelatedJobInterface
{
    public $args;

    public function perform()
    {
        $args = $this->args;
    }
}
