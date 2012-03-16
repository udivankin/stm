<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
    
    // check if username isn`t taken yet   
    function checkUnique($username,$email)
    {
        $select = $this->_db->select()
                            ->from($this->_name,array('username'))
                            ->where('username=?',$username)
                            ->orWhere('email=?',$email);
        $result = $this->getAdapter()->fetchOne($select);
        if($result){
            return true;
        }
        return false;
    }
    
    
    // get username by email, needed by auth controller
    function getUserNameByEmail($email)
    {
        $row = $this->fetchRow("email = '$email'");
        if ($row) { return $row->username; } 
        else { return false; }
    }
    
    
}

