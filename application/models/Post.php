<?php

class Application_Model_Post
{
    public $post_id;
    public $message      = null;
    public $highlight    = 0;
    public $pin_to_top   = 0;
    public $tag          = 0;
    public $milestone_id = null;
    public $event_id     = null;
    public $image_id     = null;
    public $video_id     = null;
    public $poll_id      = null;
    public $schedule     = '';
    public $privacy      = '';
    public $type         = 0;
    public $is_posted    = 1;
    public $addtime;
    public $updtime;
}

