<?php

class Application_Model_DbTable_Stories extends Zend_Db_Table_Abstract
{

    protected $_name = 'stories';

    // CRUD methods
    
    // add
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
    
    // get single story by ID - needed by edit form    
    public function getStory($id) {
        $result = $this->fetchRow('id = '.$id);
	if ($result) return $result->toArray();
    }
    
    // get all related stories
    public function getRelatedStories($username) {
        $result = $this->fetchAll('author = "'.$username.'" OR officer = "'.$username.'"');
	if ($result) return $result->toArray();
    }
    
    
    // check if specified user is author of story    
    public function isAuthor($id,$author) {
        $result = $this->fetchRow('id = '.$id.' AND author = "'.$author.'"');
	if ($result) return true;
    }

    // check if specified user is author or officer    
    public function isRelated($id,$username) {
        $result = $this->fetchRow('id = '.$id.' AND ( author = "'.$username.'" OR officer = "'.$username.'" ) ');
	if ($result) return true;
    }
    
    // update
    public function updateStory($id,$title,$desc,$officer)
    {
        $data = array(
            'title' => $title,
            'desc' => $desc,
            'officer' => $officer,
        );
        $this->update($data, 'id = '.$id);
    }
    
    // update status
    public function updateStoryStatus($id,$status)
    {
        $this->update(array('status' => $status), 'id = '.$id);
    }

    //update rating
    public function setStoryRating($id,$rating)
    {
        $this->update(array('rating' => $rating), 'id = '.$id);
    }
    
    // delete
    public function deleteStory($id)
    {
        $this->delete('id = '.$id);
    }

    // get officers list for story list filtering
    public function getStoriesOfficerList($username)
    {
        $result = $this->fetchAll($this->select()->from($this->_name, array('officer'))->where('author = ?',$username)->orWhere('officer = ?',$username)->group('officer'));
	return $result;
    }
 
    // get officers list for story list filtering
    public function getStoryIDs()
    {
        $result = $this->fetchAll($this->select()->from($this->_name, array('id')));
        $arr = array();
        foreach ($result as $res) {
            $arr[] = $res['id'];
        }
        return $arr;
    }
    
    
}