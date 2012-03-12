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
	    $this->userInfo = Zend_Auth::getInstance()->getStorage()->read();
        }
        else $this->_helper->redirector('login','Auth');
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
        if (isset($str)) $this->view->stories = $str;
	$this->view->officers = $this->stories->getStoriesOfficerList();
    }

    public function addCommentAction()
    {
        // action body
	//$this->_helper->layout->disableLayout();
	
	if ($this->getRequest()->isPost()) {
	    $commentText = false;
	    $storyID = false;
	    $intValidator = new Zend_Validate_Digits();
	    if ($intValidator->isValid($this->_getParam('storyID'))) {
		$storyID = $this->_getParam('storyID');
	    }
	    // TODO: XSS and REGEX in comment field
	    $regexValidator = new Zend_Validate_Regex(array('pattern' => '/^[а-яa-z0-9\.\,\:\#\(\)\{\}\[\]\_\-\+\&\?\!\@\"\'\=\;]/i'));
	    if ($regexValidator->isValid($this->_getParam('commentText'))) {
		$commentText = $this->_getParam('commentText');
	    }
	    if ($storyID && $commentText) {
		$this->comments->addComment($storyID, $this->userInfo->username, $commentText);
		$res['result']=1;
		$res['text']=$this->userInfo->username.' wrote: '.$commentText;
	    } else {
		$res['result']=0;
	    }
	    $this->view->output = $res;
	} 
	
    }

    public function deleteCommentAction()
    {
        // action body
	if ($this->getRequest()->isPost()) {
	    $result = 0;
	    $intValidator = new Zend_Validate_Digits();
	    if ($intValidator->isValid($this->_getParam('commentID'))) {
		$this->comments->deleteComment($this->_getParam('commentID'));
		$result = 1;
	    }
	    $this->view->output = array('result'=>$result);	    
	}
    }

    public function addStoryAction()
    {
        // action body
    }

    public function deleteStoryAction()
    {
	if ($this->getRequest()->isPost()) {
	    $result = 0;
	    $intValidator = new Zend_Validate_Digits();
	    if ($intValidator->isValid($this->_getParam('storyID'))) {
		$this->stories->deleteStory($this->_getParam('storyID'));
		$result = 1;
	    }
	    $this->view->output = array('result'=>$result);	    
	}
    }

    public function updateStoryAction()
    {
        // action body
    }

    public function updateStoryStatusAction()
    {
        // action body
    }


}







