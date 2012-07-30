<?php

class Application_Model_DbManager_PostManager {

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
            $this->setDbTable('Application_Model_DbTable_Post');
        }
        return $this->_dbTable;
    }

    private function __setAttribute($postObj) {
        if (count($postObj) == 1) {
            $post = new Application_Model_Post();
            $post->setOptions(array(
                "postId"    => $postObj->post_id,
                "message"   => $postObj->message,
                "highlight" => $postObj->highlight,
                "pinToTop"  => $postObj->pin_to_top,
                "isTagged"  => $postObj->is_tagged,
                "milestoneId" => $postObj->milestone_id,
                "eventId"   => $postObj->event_id,
                "imageId"   => $postObj->image_id,
                "videoId"   => $postObj->video_id,
                "pollId"    => $postObj->poll_id,
                "schedule"  => $postObj->schedule,
                "privacy"   => $postObj->privacy,
                "type"      => $postObj->type,
                "isPosted"  => $postObj->is_posted,
                "addtime"   => $postObj->addtime,
                "updtime"   => $postObj->updtime
            ));
            return $post;
        } elseif (count($postObj) > 1) {
            $postList = array();
            foreach ($postObj as $row) {
                $post = new Application_Model_Post();
                $post->setOptions(array(
                    "postId"    => $row->post_id,
                    "message"   => $row->message,
                    "highlight" => $row->highlight,
                    "pinToTop"  => $row->pin_to_top,
                    "isTagged"  => $row->is_tagged,
                    "milestoneId" => $row->milestone_id,
                    "eventId"   => $row->event_id,
                    "imageId"   => $row->image_id,
                    "videoId"   => $row->video_id,
                    "pollId"    => $row->poll_id,
                    "schedule"  => $row->schedule,
                    "privacy"   => $row->privacy,
                    "type"      => $row->type,
                    "isPosted"  => $row->is_posted,
                    "addtime"   => $row->addtime,
                    "updtime"   => $row->updtime
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

    public function findLastest($page_id, $num = 1) {
        $table = $this->getDbTable();
        $select = $table->select();
        $select->where("page_id = ?", $page_id)
                ->order("addtime DESC")
                ->limit($num);
        if ($num == 1)
            return $this->__setAttribute($table->fetchRow($select));
        else
            return $this->__setAttribute($table->fetchAll($select));
    }

    public function findByAddtime($page_id, $fromDate, $toDate = False) {
        $table = $this->getDbTable();
        $select = $table->select();
        if (!$toDate) {
            $select->where("page_id = ?", $page_id)
                    ->where("addtime >= '?'", $fromDate);
        } else {
            $select->where("page_id = ?", $page_id)
                    ->where("addtime >= '?'", $fromDate)
                    ->where("addtime <= '?'", $toDate);
        }

        $resultSet = $table->fetchAll($select);

        return $this->__setAttribute($resultSet);
    }

    public function findByPosted($page_id, $is_posted = 1) {
        //$posted : 1 = has already posted | 0 = is not posted yet
        $table = $this->getDbTable();
        $select = $table->select();
        $select->where("page_id = ?", $page_id)
                ->where("is_posted = ?", $is_posted);
        $resultSet = $table->fetchAll($select);

        return $this->__setAttribute($resultSet);
    }

    //UPDATE OBJECT SECTION
    public function updateImage($page_id, $post_id, $image_id) {
        $table = $this->getDbTable();
        $adapter = $table->getAdapter();
        $adapter->beginTransaction();
        $data = array(
            "image_id" => $image_id
        );

        $where["page_id = ?"] = $page_id;
        $where["post_id = ?"] = $post_id;

        try {
            $table->update($data, $where);
            $adapter->commit();
            return True;
        } catch (Zend_Db_Exception $e) {
            $adapter->rollback();
            return False;
        }
    }

    public function updateVideo($page_id, $post_id, $video_id) {
        $table = $this->getDbTable();

        $data = array(
            "video_id" => $video_id
        );

        $where["page_id = ?"] = $page_id;
        $where["post_id = ?"] = $post_id;

        try {
            $table->update($data, $where);
            return True;
        } catch (Zend_Db_Exception $e) {
            return False;
        }
    }

    public function updatePoll($page_id, $post_id, $poll_id) {
        $table = $this->getDbTable();

        $data = array(
            "poll_id" => $poll_id
        );

        $where["page_id = ?"] = $page_id;
        $where["post_id = ?"] = $post_id;

        try {
            $table->update($data, $where);
            return True;
        } catch (Zend_Db_Exception $e) {
            return False;
        }
    }

    public function updateMilestone($page_id, $post_id, $milestone_id) {
        $table = $this->getDbTable();

        $data = array(
            "milestone_id" => $milestone_id
        );

        $where["page_id = ?"] = $page_id;
        $where["post_id = ?"] = $post_id;

        try {
            $table->update($data, $where);
            return True;
        } catch (Zend_Db_Exception $e) {
            return False;
        }
    }

    public function updateEvent($page_id, $post_id, $event_id) {
        $table = $this->getDbTable();

        $data = array(
            "event_id" => $event_id
        );

        $where["page_id = ?"] = $page_id;
        $where["post_id = ?"] = $post_id;

        try {
            $table->update($data, $where);
            return True;
        } catch (Zend_Db_Exception $e) {
            return False;
        }
    }

    public function updateSchedule($page_id, $post_id, $schedule) {
        $table = $this->getDbTable();

        $data = array(
            "schedule" => $schedule
        );

        $where["page_id = ?"] = $page_id;
        $where["post_id = ?"] = $post_id;

        try {
            $table->update($data, $where);
            return True;
        } catch (Zend_Db_Exception $e) {
            return False;
        }
    }

    //INSERT RECORD SECTION
    public function insertNewPost(Application_Model_Post $post) {
        if (get_class($post) == "Application_Model_Post") {
            $table = $this->getDbTable();
            $row = $table->createRow();
            $row->page_id = $post->page_id;
            $row->message = $post->message;
            $row->highlight = $post->highlight;
            $row->pin_to_top = $post->pin_to_top;
            $row->tag = $post->tag;
            $row->milestone_id = $post->milestone_id;
            $row->event_id = $post->event_id;
            $row->image_id = $post->image_id;
            $row->video_id = $post->video_id;
            $row->poll_id = $post->poll_id;
            $row->schedule = $post->schedule;
            $row->privacy = $post->privacy;
            $row->type = $post->type;
            $row->is_posted = $post->is_posted;

            $row->save();
            // now fetch the id of the row you just created and return it 
            $post->post_id = $this->_db->lastInsertId();

            return $post;
        } else {
            throw new Exception('Unvalid object');
        }
    }

}

