<?php

class Application_Model_TagPost {

    protected $_tagPostId;
    protected $_postId;
    protected $_uid;
    protected $_userName;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Tag property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid tag property');
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

    public function getTagPostId() {
        return $this->_tagPostId;
    }

    public function setTagPostId($_tagPostId) {
        $this->_tagPostId = $_tagPostId;
    }

    public function getPostId() {
        return $this->_postId;
    }

    public function setPostId($_postId) {
        $this->_postId = $_postId;
    }

    public function getUid() {
        return $this->_uid;
    }

    public function setUid($_uid) {
        $this->_uid = $_uid;
    }

    public function getUserName() {
        return $this->_userName;
    }

    public function setUserName($_userName) {
        $this->_userName = $_userName;
    }

}

