<?php

class Application_Model_Facebook_DbManager_PostManager {

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
            $this->setDbTable('Application_Model_Facebook_DbTable_Post');
        }
        return $this->_dbTable;
    }

    private function __setAttribute($postObj) {
        if (count($postObj) == 1) {
            $post = new Application_Model_Facebook_Post();
            $post->setOptions(array(
                "postId"        => $postObj->post_id,
                "message"       => $postObj->message,
                "picture"       => $postObj->picture,
                "type"          => $postObj->type,
                "createdTime"   => $postObj->created_time,
                "updatedTime"   => $postObj->updated_time,
            ));
            return $post;
        } elseif (count($postObj) > 1) {
            $postList = array();
            foreach ($postObj as $row) {
                $post = new Application_Model_Facebook_Post();
                $post->setOptions(array(
                    "postId"        => $row->post_id,
                    "message"       => $row->message,
                    "picture"       => $row->picture,
                    "type"          => $row->type,
                    "createdTime"   => $row->created_time,
                    "updatedTime"   => $row->updated_time,
                ));
                $postList[] = $post;
            }
            return $postList;
        }
    }

    //FIND OBJECT SECTION
    public function findById($post_id) {
        $result = $this->getDbTable()->find($post_id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        return $this->__setAttribute($row);
    }

    public function findByIdList($post_id_list) {
        //$post_id_list : post id array 
        $table = $this->getDbTable()->find($post_id_list);
        $resultSet = $table->fetchAll();
        return $this->__setAttribute($resultSet);
    }

    public function findByPage($page_id) {
        $table = $this->getDbTable();
        $select = $table->select();
        $select->where("page_id = ?", $page_id);
        $resultSet = $table->fetchAll($select);
        return $this->__setAttribute($resultSet);
    }

    public function findLatest($page_id, $num = 1) {
        $table = $this->getDbTable();
        $select = $table->select();
        $select->where("page_id = ?", $page_id)
                ->order("created_time DESC")
                ->limit($num);
        if ($num == 1)
            return $this->__setAttribute($table->fetchRow($select));
        else
            return $this->__setAttribute($table->fetchAll($select));
    }

    public function findByCreatedTime($page_id, $fromDate, $toDate = False) {
        $table = $this->getDbTable();
        $select = $table->select();
        if (!$toDate) {
            $select->where("page_id = ?", $page_id)
                    ->where("created_time >= '?'", $fromDate);
        } else {
            $select->where("page_id = ?", $page_id)
                    ->where("created_time >= '?'", $fromDate)
                    ->where("created_time <= '?'", $toDate);
        }

        $resultSet = $table->fetchAll($select);

        return $this->__setAttribute($resultSet);
    }

    //UPDATE OBJECT SECTION
  
    //INSERT RECORD SECTION
    public function insertPost(Application_Model_Facebook_Post $post) {
        if (get_class($post) == "Application_Model_Facebook_Post") {
            $table = $this->getDbTable();
            $row = $table->createRow();
            $row->page_id       = $post->page_id;
            $row->message       = $post->message;
            $row->picture       = $post->picture;
            $row->type          = $post->type;
            $row->createdTime   = $post->createdTime;
            $row->updatedTime   = $post->updatedTime;

            $row->save();
            // now fetch the id of the row you just created and return it 
            $post->post_id = $this->_db->lastInsertId();

            return $post;
        } else {
            throw new Exception('Unvalid object');
        }
    }

}

