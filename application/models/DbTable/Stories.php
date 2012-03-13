<?php

class Application_Model_DbTable_Stories extends Zend_Db_Table_Abstract
{

    protected $_name = 'stories';

    // CRUD methods
    
    public function addStory($title,$desc,$author,$officer,$rating,$status)
    {
        $data = array(
            'title' => $title,
            'desc' => $desc,
            'author' => $author,
            'officer' => $officer,
            'rating' => $rating,
            'status'=>$status
        );
        $this->insert($data);
    }
    
    public function updateStory($id,$title,$desc,$author,$officer,$rating,$status)
    {
        $data = array(
            'title' => $title,
            'desc' => $desc,
            'author' => $author,
            'officer' => $officer,
            'rating' => $rating,
            'status'=>$status
        );
        $this->update($data, 'id = '.$id);
    }
    
    public function updateStoryStatus($id,$status)
    {
        $this->update(array('status' => $status), 'id = '.$id);
    }
    
    public function deleteStory($id)
    {
        $this->delete('id = '.$id);
    }

    public function getStoriesOfficerList()
    {
        $result = $this->fetchAll($this->select()->from($this->_name, array('officer'))->group('officer'));
	return $result;
    }
    
}

