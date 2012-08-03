<?php

class Application_Model_Facebook_DbTable_Post extends Zend_Db_Table_Abstract
{

    protected $_name = 'post';
    protected $_schema  = 'social_xpert_facebook';
    protected $_adapter = 'facebook';
    protected $_primary = 'post_id';

}


