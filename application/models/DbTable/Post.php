<?php

class Application_Model_DbTable_Post extends Zend_Db_Table_Abstract
{

    protected $_name = 'post';
    protected $_schema  = 'social_xpert_app';
    protected $_adapter = 'default';
    protected $_primary = 'post_id';

}

