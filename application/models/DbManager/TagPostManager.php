<?php

class Application_Model_DbManager_TagPostManager {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_TagPost');
        }
        return $this->_dbTable;
    }

    //FIND OBJECT SECTION
    public function findById($post_id) {
        $result = $this->getDbTable()->find($post_id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $tag = new Application_Model_TagPost();
        $tag->setOptions(array(
            "tagPostId"   => $row->tag_post_id,
            "postId"      => $row->post_id,
            "uid"         => $row->uid,
            "userName"    => $row->user_name,
        ));
        return $tag;
    }
    
    public function findByPostId($post_id){
        //$post_id_list : post id array 
        $table = $this->getDbTable();
        $select = $table->select();
        $select->where("post_id = ?",$post_id);
        $resultSet = $table->fetchAll($select);
        $tagList   = array();
        foreach ($resultSet as $row) {
            $tag = new Application_Model_TagPost();
            $tag->setOptions(array(
                "tagPostId"   => $row->tag_post_id,
                "postId"      => $row->post_id,
                "uid"         => $row->uid,
                "userName"    => $row->user_name,
            ));
            $tagList[] = $tag;
        }
        return $tagList;
    }
}

