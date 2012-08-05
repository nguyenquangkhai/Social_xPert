<?php

class Application_Model_Facebook_DbManager_PageManager {

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
            $this->setDbTable('Application_Model_Facebook_DbTable_Page');
        }
        return $this->_dbTable;
    }

    private function __setAttribute($pageObj) {
        if (count($pageObj) == 1) {
            $page = new Application_Model_Facebook_Page();
            $page->setOptions(array(
                "pageId"        => $postObj->pageId,
                "name"          => $postObj->name,
                "link"          => $postObj->link,
                "category"      => $postObj->category,
                "accessToken"   => $postObj->accessToken,
            ));
            return $page;
        } elseif (count($pageObj) > 1) {
            $pageList = array();
            foreach ($pageObj as $row) {
                $page = new Application_Model_Facebook_Page();
                $page->setOptions(array(
                    "pageId"        => $postObj->pageId,
                    "name"          => $postObj->name,
                    "link"          => $postObj->link,
                    "category"      => $postObj->category,
                    "accessToken"   => $postObj->accessToken,
                ));
                $pageList[] = $page;
            }
            return $pageList;
        }
    }

    //FIND OBJECT SECTION
    public function findById($page_id) {
        $result = $this->getDbTable()->find($page_id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        return $this->__setAttribute($row);
    }

    public function findByIdList($page_id_list) {
        //$page_id_list : page id array 
        $table = $this->getDbTable()->find($page_id_list);
        $resultSet = $table->fetchAll();
        return $this->__setAttribute($resultSet);
    }

    //UPDATE OBJECT SECTION
  
    //INSERT RECORD SECTION
    public function insertPage(Application_Model_Facebook_Page $page) {
        if (get_class($page) == "Application_Model_Facebook_Page") {
            $table = $this->getDbTable();
            $row = $table->createRow();
            $row->page_id       = $page->pageId;
            $row->name          = $page->name;
            $row->picture       = $page->picture;
            $row->category      = $page->category;
            $row->access_token  = $page->accessToken;

            $row->save();
            // now fetch the id of the row you just created and return it 
            $page->page_id = $this->_db->lastInsertId();

            return $page;
        } else {
            throw new Exception('Unvalid object');
        }
    }

}


