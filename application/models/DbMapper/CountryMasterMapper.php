<?php

class Application_Model_CountryMasterMapper {

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
            $this->setDbTable('Application_Model_DbTable_CountryMaster');
        }
        return $this->_dbTable;
    }

    public function findById($country_master_id) {
        $result = $this->getDbTable()->find($country_master_id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $country_master = new Application_Model_CountryMaster();
        $country_master->setId($row->country_master_id)
                       ->setCountryName($row->country_name);
        return $country_master;
    }

    public function findByNamePart($country_name_part) {
        $table = $this->getDbTable();
        
        $select = $table->select();
        $select->where('bug_status LIKE "%?%"', $country_name_part);
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return;
        }
        $entries   = array();
        foreach ($resultSet as $row) {
            $country_master = new Application_Model_CountryMaster();
            $country_master->setId($row->country_master_id)
                           ->setCountryName($row->country_name);
            $entries[] = $country_master;
        }
        return $entries;
    }

}

