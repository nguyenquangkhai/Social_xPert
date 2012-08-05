<?php

class Application_Model_Facebook_DbTable_Page extends Zend_Db_Table_Abstract
{

    protected $_name = 'page';
    protected $_schema  = 'social_xpert_facebook';
    protected $_adapter = 'facebook';
    protected $_primary = 'page_id';

}
