<?php

class Application_Model_Post {

    protected $_postId;
    protected $_message = null;
    protected $_highlight = 0;
    protected $_pinToTop = 0;
    protected $_isTagged = 0;
    protected $_tag = null;
    protected $_milestoneId = null;
    protected $_eventId = null;
    protected $_imageId = null;
    protected $_videoId = null;
    protected $_pollId = null;
    protected $_schedule = '';
    protected $_privacy = '';
    protected $_type = 0;
    protected $_isPosted = 1;
    protected $_addtime;
    protected $_updtime;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Post property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Post property');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getPostId() {
        return $this->_postId;
    }

    public function setPostId($_postId) {
        $this->_postId = $_postId;
    }

    public function getMessage() {
        return $this->_message;
    }

    public function setMessage($_message) {
        $this->_message = $_message;
    }

    public function getHighlight() {
        return $this->_highlight;
    }

    public function setHighlight($_highlight) {
        $this->_highlight = $_highlight;
    }

    public function getPinToTop() {
        return $this->_pinToTop;
    }

    public function setPinToTop($_pinToTop) {
        $this->_pinToTop = $_pinToTop;
    }

    public function getIsTagged() {
        return $this->_isTagged;
    }

    public function setIsTagged($_isTagged) {
        $this->_isTagged = $_isTagged;
        //If isTagged was tagged, get the list of tag name and tag id
        if($_isTagged == 1){
            $tagManager = new Application_Model_DbManager_TagPostManager();
            $this->_tag = $tagManager->findByPostId($this->getPostId());
        }
    }
    
    public function getTag() {
        return $this->_tag;
    }

    public function setTag($_tag) {
        $this->_tag = $_tag;
    }

    
    public function getMilestoneId() {
        return $this->_milestoneId;
    }

    public function setMilestoneId($_milestoneId) {
        $this->_milestoneId = $_milestoneId;
    }

    public function getEventId() {
        return $this->_eventId;
    }

    public function setEventId($_eventId) {
        $this->_eventId = $_eventId;
    }

    public function getImageId() {
        return $this->_imageId;
    }

    public function setImageId($_imageId) {
        $this->_imageId = $_imageId;
    }

    public function getVideoId() {
        return $this->_videoId;
    }

    public function setVideoId($_videoId) {
        $this->_videoId = $_videoId;
    }

    public function getPollId() {
        return $this->_pollId;
    }

    public function setPollId($_pollId) {
        $this->_pollId = $_pollId;
    }

    public function getSchedule() {
        return $this->_schedule;
    }

    public function setSchedule($_schedule) {
        $this->_schedule = $_schedule;
    }

    public function getPrivacy() {
        return $this->_privacy;
    }

    public function setPrivacy($_privacy) {
        $this->_privacy = $_privacy;
    }

    public function getType() {
        return $this->_type;
    }

    public function setType($_type) {
        $this->_type = $_type;
    }

    public function getIsPosted() {
        return $this->_isPosted;
    }

    public function setIsPosted($_isPosted) {
        $this->_isPosted = $_isPosted;
    }

    public function getAddtime() {
        return $this->_addtime;
    }

    public function setAddtime($_addtime) {
        $this->_addtime = $_addtime;
    }

    public function getUpdtime() {
        return $this->_updtime;
    }

    public function setUpdtime($_updtime) {
        $this->_updtime = $_updtime;
    }

}

