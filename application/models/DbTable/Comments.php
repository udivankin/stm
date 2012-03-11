<?php

class Application_Model_DbTable_Comments extends Zend_Db_Table_Abstract
{

    protected $_name = 'comments';

    // CRUD methods
    
    public function addComment($storyID,$author,$text)
    {
        $data = array(
            'storyID' => $title,
            'author' => $author,
            'text' => $text
        );
        $this->insert($data);
    }
    
    public function updateComment($id,$storyID,$author,$text)
    {
        $data = array(
            'storyID' => $title,
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

