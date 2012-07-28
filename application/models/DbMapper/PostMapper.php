<?php

class Application_Model_DbMapper_PostMapper {

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
            $this->setDbTable('Application_Model_DbTable_Posts');
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
        return $row;
    }
    
    public function findByIdList($post_id_list){
        //$post_id_list : post id array 
        $table = $this->getDbTable()->find($post_id_list);
        $resultSet = $table->fetchAll();
        
        return $resultSet;
    }
    
    public function findByPage($page_id){
        $table = $this->getDbTable();
        $select = $table->select();
        $select->where("page_id = ?",$page_id);
        $resultSet = $table->fetchAll($select);
        
        return $resultSet;
    }
    
    public function findLastest($page_id, $num = 1){
        $table = $this->getDbTable();
        $select = $table->select();
        $select->where("page_id = ?",$page_id)
               ->order("addtime DESC")
               ->limit($num);
        if($num == 1)
            $resultSet = $table->fetchRow($select);
        else
            $resultSet = $table->fetchAll($select);
        
        return $resultSet;
    }

    public function findByAddtime($page_id, $fromDate, $toDate = False) {
        $table = $this->getDbTable();
        $select = $table->select();
        if(!$toDate){
            $select->where("page_id = ?", $page_id)
                   ->where("addtime >= '?'", $fromDate);
        }else{
            $select->where("page_id = ?",$page_id)
                   ->where("addtime >= '?'",$fromDate)
                   ->where("addtime <= '?'",$toDate);
        }
        
        $resultSet = $table->fetchAll($select);
        
        return $resultSet;
    }
    
    public function findByPosted($page_id, $is_posted = 1){
        //$posted : 1 = has already posted | 0 = is not posted yet
        $table = $this->getDbTable();
        $select = $table->select();
        $select->where("is_posted = ?", $is_posted);
        $resultSet = $table->fetchAll($select);
        
        return $resultSet;
    }
    
    //UPDATE OBJECT SECTION
    public function updateImage($page_id, $post_id, $image_id){
        $table = $this->getDbTable();
        
        $select = $table->select();
        $select->where("page_id = ?",$page_id)
               ->where("post_id = ?",$post_id);
        
        $row = $table->fetchRow($select);
        if($row != null){
            $row->image_id = $image_id;
            $row->save();
            return $row;
        }else{
            return null;
        }
    }
    
    public function updateVideo($page_id, $post_id, $video_id){
        $table = $this->getDbTable();
        
        $select = $table->select();
        $select->where("page_id = ?",$page_id)
               ->where("post_id = ?",$post_id);
        
        $row = $table->fetchRow($select);
        if($row != null){
            $row->video_id = $video_id;
            $row->save();
            return $row;
        }else{
            return null;
        }
    }
    
    public function updatePoll($page_id, $post_id, $poll_id){
        $table = $this->getDbTable();
        
        $select = $table->select();
        $select->where("page_id = ?",$page_id)
               ->where("post_id = ?",$post_id);
        
        $row = $table->fetchRow($select);
        if($row != null){
            $row->poll_id = $poll_id;
            $row->save();
            return $row;
        }else{
            return null;
        }
    }
    
    public function updateMilestone($page_id, $post_id, $milestone_id){
        $table = $this->getDbTable();
        
        $select = $table->select();
        $select->where("page_id = ?",$page_id)
               ->where("post_id = ?",$post_id);
        
        $row = $table->fetchRow($select);
        if($row != null){
            $row->milestone_id = $milestone_id;
            $row->save();
            return $row;
        }else{
            return null;
        }
    }
    
    public function updateEvent($page_id, $post_id, $event_id){
        $table = $this->getDbTable();
        
        $select = $table->select();
        $select->where("page_id = ?",$page_id)
               ->where("post_id = ?",$post_id);
        
        $row = $table->fetchRow($select);
        if($row != null){
            $row->event_id = $event_id;
            $row->save();
            return $row;
        }else{
            return null;
        }
    }
}

