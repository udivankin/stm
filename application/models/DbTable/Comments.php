<?php

class Application_Model_DbTable_Comments extends Zend_Db_Table_Abstract
{

    protected $_name = 'comments';

    // CRUD methods
    
    public function getCommentsByID($storyID) {
        $result = $this->fetchAll('storyID = '.$storyID);
        return $result;
    }
    
    public function addComment($storyID,$author,$text)
    {
        $data = array(
            'storyID' => $storyID,
            'author' => $author,
            'text' => $text
        );
        $this->insert($data);
    }
    
    public function updateComment($id,$storyID,$author,$text)
    {
        $data = array(
            'storyID' => $storyID,
            'author' => $author,
            'text' => $text
        );
        $this->update($data, 'id = '.$id);
    }
    
    public function deleteComment($id)
    {
        $this->delete('id = '.$id);
    }
    
}

