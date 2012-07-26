<?php

class Application_Model_CountryMaster {

    protected $_country_master_id;
    protected $_country_name;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guestbook property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guestbook property');
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

    public function setCountryName($text) {
        $this->_country_name = (string) $text;
        return $this;
    }

    public function getCountryName() {
        return $this->_country_name;
    }
    
    public function setId($id)
    {
        $this->_country_master_id = (int) $id;
        return $this;
    }

    public function getId() {
        return $this->_country_master_id;
    }

}

