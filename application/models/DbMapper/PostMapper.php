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
        
    }
    
    public function findLastest($num = 1){
        $table = $this->getDbTable();
        $select = $table->select();
        $select->order("addtime DESC")
               ->limit($num);
        
        $resultSet = $table->current();
        
        return $resultSet;
    }

    public function findByAddtime($fromDate, $toDate = False) {
        $table = $this->getDbTable();
        $select = $table->select();
        if(!$toDate){
            $select->where("addtime >= '?'", $fromDate);
        }else{
            $select->where("addtime >= '?'",$fromDate)
                   ->where("addtime <= '?'",$toDate);
        }
        
        $resultSet = $table->fetchAll($select);
        
        return $resultSet;
    }
    
}

