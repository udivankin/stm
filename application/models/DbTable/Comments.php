<?php

class Application_Model_DbTable_Comments extends Zend_Db_Table_Abstract
{

    protected $_name = 'comments';

    // CRUD methods
    
    // get by ID
    public function getCommentsByID($storyID) {
        $result = $this->fetchAll('storyID = '.$storyID);
        return $result;
    }
    
    // check if specified user is author of comment
    public function isAuthor($id,$author) {
        $result = $this->fetchRow('id = '.$id.' AND author = "'.$author.'"');
	if ($result) return true;
    }
    
    // add comment
    public function addComment($storyID,$author,$text)
    {
        $data = array(
            'storyID' => $storyID,
            'author' => $author,
            'text' => $text
        );
        $this->insert($data);
    }
    
    // delete
    public function deleteComment($id)
    {
        $this->delete('id = '.$id);
    }
    
}

