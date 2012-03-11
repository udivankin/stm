<?php

class StoriesController extends Zend_Controller_Action
{

    public function init()
    {
        // if authorised initializing necessary models
	if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->stories = new Application_Model_DbTable_Stories();
            $this->comments = new Application_Model_DbTable_Comments();            
	    $this->view->userInfo = Zend_Auth::getInstance()->getStorage()->read();
        }
        else {
            $this->_helper->redirector('login','Auth');
        }
    }

    public function indexAction()
    {
	// fetch all stories into an one big array
        // this client-side oriented approach is definately not for production :)
	$result = $this->stories->fetchAll();
        foreach ($result as $res) {
            $storycomments = $this->comments->getCommentsByID($res['id']);
            $str[]=array('content'=>$res,'comments'=>$storycomments);
        }
        $this->view->stories = $str;
	
    }


}

