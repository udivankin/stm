<?php

class Application_Model_DbTable_Stories extends Zend_Db_Table_Abstract
{

    protected $_name = 'stories';

    // CRUD methods
    
    public function addStory($title,$desc,$author,$officer)
    {
        $data = array(
            'title' => $title,
            'desc' => $desc,
            'author' => $author,
            'officer' => $officer,
        );
        $this->insert($data);
    }
    
    public function getStory($id) {
        $result = $this->fetchRow('id = '.$id);
	if ($result) return array('id'=>$id,'title'=>$result['title'],'desc'=>$result['desc'],'officer'=>$result['officer']);
    }
 
    public function isAuthor($id,$author) {
        $result = $this->fetchRow('id = '.$id.' AND author = "'.$author.'"');
	if ($result) return true;
    }
    
    public function updateStory($id,$title,$desc,$officer)
    {
        $data = array(
            'title' => $title,
            'desc' => $desc,
            'officer' => $officer,
        );
        $this->update($data, 'id = '.$id);
    }
    
    public function updateStoryStatus($id,$status)
    {
        $this->update(array('status' => $status), 'id = '.$id);
    }

    public function setStoryRating($id,$rating)
    {
        $this->update(array('rating' => $rating), 'id = '.$id);
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

